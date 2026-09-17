<?php

namespace App\Services;

use App\Models\SurveyProgress;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyProgressService
{
    /**
     * Kolom metadata umum yang tidak dihitung dalam kalkulasi kelengkapan kuesioner.
     */
    protected const DEFAULT_EXCLUDED_FIELDS = [
        'id',
        'id_kg_p2',
        'id_p4',
        'id_p3_rw',
        'id_p3',
        'id_survey',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
        'created_at',
        'updated_at',
    ];

    /**
     * Sinkronkan progress suatu indikator/form ke tabel survey_progress.
     *
     * @param string $idParent     ID entitas induk (id_kg_p2 untuk Keluarga, id_p4 untuk RT, dst.)
     * @param string $formCode     Kode instrumen (misal: 'P4', 'P4.21', 'P6')
     * @param string $table        Nama tabel database kuesioner
     * @param string $parentColumn Nama kolom foreign key ke induk
     * @param array  $options      Opsi tambahan (excludes, custom conditional rules)
     * @return SurveyProgress
     */
    public function syncProgress(
        string $idParent,
        string $formCode,
        string $table,
        string $parentColumn = 'id_kg_p2',
        array $options = []
    ): SurveyProgress {
        try {
            $records = DB::table($table)->where($parentColumn, $idParent)->get();

            if ($records->isEmpty()) {
                return SurveyProgress::updateOrCreate(
                    ['id_parent' => $idParent, 'form_code' => $formCode],
                    ['skor_wajib' => 0, 'skor_total' => 0]
                );
            }

            // Jika record ada, artinya form berhasil disubmit (lolos filter required) => skor_wajib = 100
            $skorWajib = 100;
            $skorTotal = $this->calculateCompleteness($records, $table, $options);

            return SurveyProgress::updateOrCreate(
                ['id_parent' => $idParent, 'form_code' => $formCode],
                ['skor_wajib' => $skorWajib, 'skor_total' => $skorTotal]
            );
        } catch (\Throwable $e) {
            Log::error("Gagal sinkron progress [{$formCode}] untuk parent [{$idParent}]: " . $e->getMessage());
            
            // Fallback aman agar tidak menggagalkan flow utama
            return SurveyProgress::updateOrCreate(
                ['id_parent' => $idParent, 'form_code' => $formCode],
                ['skor_wajib' => 100, 'skor_total' => 100]
            );
        }
    }

    /**
     * Hitung persentase kelengkapan data (skor_total) dari kumpulan baris record.
     * Mengabaikan metadata dan pertanyaan kondisional yang tidak relevan.
     */
    public function calculateCompleteness(Collection $records, string $table, array $options = []): int
    {
        if ($records->isEmpty()) {
            return 0;
        }

        $customExcludes = $options['excludes'] ?? [];
        $excluded = array_flip(array_merge(self::DEFAULT_EXCLUDED_FIELDS, $customExcludes));

        $totalExpected = 0;
        $totalFilled = 0;

        foreach ($records as $record) {
            $row = (array) $record;

            // Terapkan aturan conditional/skip logic untuk meniadakan field yang tidak relevan dari denominator
            $row = $this->filterConditionalFields($row, $table);

            foreach ($row as $col => $val) {
                if (isset($excluded[$col])) {
                    continue;
                }

                $totalExpected++;

                // Nilai 0 atau '0' dihitung terisi. Hanya null dan string kosong yang dihitung belum terisi.
                if ($val !== null && $val !== '') {
                    $totalFilled++;
                }
            }
        }

        if ($totalExpected === 0) {
            return 100;
        }

        $percentage = (int) round(($totalFilled / $totalExpected) * 100);
        return min(100, max(0, $percentage));
    }

    /**
     * Filter pertanyaan kondisional: jika kondisi induk tidak terpenuhi,
     * hapus kolom anak agar tidak dihitung sebagai denominator (pembagi).
     */
    protected function filterConditionalFields(array $row, string $table): array
    {
        switch ($table) {
            case 'kg_p4':
                // Jika energi memasak bukan kayu bakar ('3'), maka sumber_kayu_bakar tidak relevan
                if (isset($row['energi_untuk_memasak']) && (string) $row['energi_untuk_memasak'] !== '3') {
                    unset($row['sumber_kayu_bakar']);
                }
                break;

            case 'rt_p2':
                // Contoh: jika wilayah tidak berbatasan dengan hutan, abaikan pertanyaan fungsi hutan
                if (isset($row['wilayah_desa_dlm_hutan']) && (string) $row['wilayah_desa_dlm_hutan'] === '0') {
                    unset($row['fungsi_hutan_konservasi'], $row['fungsi_hutan_lindung'], $row['fungsi_hutan_produksi']);
                }
                break;
        }

        return $row;
    }

    /**
     * Hapus record progress jika kuesioner dihapus.
     */
    public function recordDelete(string $idParent, string $formCode): void
    {
        SurveyProgress::where('id_parent', $idParent)
            ->where('form_code', $formCode)
            ->delete();
    }

    /**
     * Ambil seluruh progress kuesioner milik satu parent (1 query cepat).
     */
    public function getProgressMap(string $idParent): Collection
    {
        return SurveyProgress::where('id_parent', $idParent)
            ->get()
            ->keyBy(fn ($item) => strtoupper($item->form_code));
    }

    /**
     * Ambil progress dengan verifikasi keberadaan fisik (Self-Healing).
     * Jika data fisik sudah tidak ada (terhapus), otomatis reset skor_wajib & skor_total ke 0.
     * Jika data fisik ada dan sudah di-cache dengan skor_wajib=100, gunakan cache (0ms).
     */
    public function getOrSyncProgress(
        string $idParent,
        string $formCode,
        string $table,
        string $parentColumn = 'id_p4',
        ?SurveyProgress $cached = null
    ): array {
        try {
            // Cek keberadaan baris fisik di database (SELECT 1 LIMIT 1, sangat cepat)
            $hasRecord = DB::table($table)->where($parentColumn, $idParent)->exists();

            if (!$hasRecord) {
                // Self-healing: jika record fisik terhapus, pastikan cache survey_progress di-reset ke 0
                if ($cached && ($cached->skor_wajib > 0 || $cached->skor_total > 0)) {
                    $cached->update(['skor_wajib' => 0, 'skor_total' => 0]);
                }
                return ['skor_wajib' => 0, 'skor_total' => 0];
            }

            // Jika record fisik ada dan sudah di-cache sebagai selesai, gunakan nilai cache
            if ($cached && $cached->skor_wajib === 100) {
                return [
                    'skor_wajib' => (int) $cached->skor_wajib,
                    'skor_total' => (int) $cached->skor_total,
                ];
            }

            // Jika belum dihitung kelengkapannya, jalankan sinkronisasi
            $synced = $this->syncProgress($idParent, $formCode, $table, $parentColumn);
            return [
                'skor_wajib' => (int) $synced->skor_wajib,
                'skor_total' => (int) $synced->skor_total,
            ];
        } catch (\Throwable $e) {
            Log::error("Error getOrSyncProgress [{$formCode}] parent [{$idParent}]: " . $e->getMessage());
            return [
                'skor_wajib' => (int) ($cached->skor_wajib ?? 0),
                'skor_total' => (int) ($cached->skor_total ?? 0),
            ];
        }
    }

    /**
     * Ambil survey aktif saat ini berdasarkan tanggal hari ini.
     */
    public static function getActiveSurvey()
    {
        $today = \Carbon\Carbon::today()->toDateString();
        return \App\Models\Survey\Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();
    }
}
