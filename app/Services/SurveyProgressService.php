<?php

namespace App\Services;

use App\Models\SurveyProgress;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

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
        'id_individu_p1',
        'id_survey',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
        'created_at',
        'updated_at',
        'is_verified',
    ];

    /**
     * Pemetaan kode indikator master RT ke tabel master acuannya.
     */
    protected const MASTER_TABLE_MAP = [
        'P502'  => 'master_jenis_industri_rt',
        'P508'  => 'master_sarana_ekonomi_rt',
        'P607'  => 'master_operator_sinyal_rt',
        'P609'  => 'master_tv_radio_rt',
        'P706'  => 'master_guna_sumber_rt',
        'P709'  => 'master_lingkungan_rt',
        'P713'  => 'master_bencana_alam_rt',
        'P902'  => 'master_klb_rt',
        'P1009' => 'master_lembaga_masyarakat_rt',
        'P1101' => 'master_perkelahian_rt',
        'P1102' => 'master_kejahatan_rt',
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
        array $options = [],
        ?string $idSurvey = null
    ): SurveyProgress {
        $idSurvey = $idSurvey ?? self::getActiveSurvey()?->id;

        try {
            $query = DB::table($table)->where($parentColumn, $idParent);
            if ($idSurvey && Schema::hasColumn($table, 'id_survey')) {
                $query->where('id_survey', $idSurvey);
            }
            $records = $query->get();

            if ($records->isEmpty()) {
                return SurveyProgress::updateOrCreate(
                    ['id_parent' => $idParent, 'form_code' => $formCode, 'id_survey' => $idSurvey],
                    ['skor_wajib' => 0, 'skor_total' => 0, 'status_verifikasi' => 'belum_diisi']
                );
            }

            $formUpper = strtoupper($formCode);
            $isMasterTable = isset(self::MASTER_TABLE_MAP[$formUpper]);
            $totalExpectedRows = $isMasterTable
                ? DB::table(self::MASTER_TABLE_MAP[$formUpper])->count()
                : $records->count();

            $hasColumnVerified = Schema::hasColumn($table, 'is_verified');
            $verifiedCount = $hasColumnVerified ? $records->where('is_verified', 1)->count() : $records->count();
            $filledCount = $records->count();

            if ($totalExpectedRows <= 0) {
                $totalExpectedRows = max(1, $filledCount);
            }

            if ($hasColumnVerified && $verifiedCount === 0) {
                // Seluruh data berasal dari hasil tarik dan belum diverifikasi
                $skorWajib = 0;
                $skorTotal = 0;
                $statusVerifikasi = 'draft_tarik';
            } elseif ($filledCount < $totalExpectedRows || ($hasColumnVerified && $verifiedCount < $filledCount)) {
                // Sebagian sudah terisi atau sebagian sudah diverifikasi
                $verifiedRatio = min(1.0, $verifiedCount / $totalExpectedRows);
                $filledRatio = min(1.0, $filledCount / $totalExpectedRows);
                $itemCompleteness = $this->calculateCompleteness(
                    $hasColumnVerified ? $records->where('is_verified', 1) : $records,
                    $table,
                    $options
                );
                $skorWajib = (int) round($verifiedRatio * 100);
                $skorTotal = (int) round($filledRatio * $itemCompleteness);
                $statusVerifikasi = 'sebagian_terverifikasi';
            } else {
                // Terisi penuh dan terverifikasi penuh
                $skorWajib = 100;
                $skorTotal = $this->calculateCompleteness($records, $table, $options);
                $statusVerifikasi = 'terverifikasi';
            }

            return SurveyProgress::updateOrCreate(
                ['id_parent' => $idParent, 'form_code' => $formCode, 'id_survey' => $idSurvey],
                ['skor_wajib' => $skorWajib, 'skor_total' => $skorTotal, 'status_verifikasi' => $statusVerifikasi]
            );
        } catch (\Throwable $e) {
            Log::error("Gagal sinkron progress [{$formCode}] untuk parent [{$idParent}]: " . $e->getMessage());
            
            return SurveyProgress::updateOrCreate(
                ['id_parent' => $idParent, 'form_code' => $formCode, 'id_survey' => $idSurvey],
                ['skor_wajib' => 0, 'skor_total' => 0, 'status_verifikasi' => 'belum_diisi']
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

            case 'individu_p2':
                if (isset($row['pekerjaan_utama']) && (string) $row['pekerjaan_utama'] !== '16') {
                    unset($row['pekerjaan_lainnya']);
                }
                break;

            case 'individu_p5':
                if (isset($row['pendidikan_terakhir']) && (string) $row['pendidikan_terakhir'] !== '10') {
                    unset($row['pendidikan_terakhir_lainnya']);
                }
                break;

            case 'rt_p5':
                if (isset($row['ada_tempat_hiburan']) && (string) $row['ada_tempat_hiburan'] === '1') {
                    unset($row['jarak_tempat_hiburan']);
                }
                break;

            case 'transaksi_tv_p6_rt':
                if (isset($row['diterima']) && (string) $row['diterima'] !== '1') {
                    unset($row['parabola']);
                }
                break;

            case 'transaksi_guna_sumber_p7_rt':
                if (isset($row['sungai']) && (string) $row['sungai'] !== '1') {
                    unset($row['kondisi_sungai']);
                }
                if (isset($row['saluran_irigasi']) && (string) $row['saluran_irigasi'] !== '1') {
                    unset($row['kondisi_saluran_irigasi']);
                }
                if (isset($row['danau']) && (string) $row['danau'] !== '1') {
                    unset($row['kondisi_danau']);
                }
                if (isset($row['embung']) && (string) $row['embung'] !== '1') {
                    unset($row['kondisi_embung']);
                }
                break;

            case 'transaksi_pencemaran_p7_rt':
                if (isset($row['pencemaran']) && (string) $row['pencemaran'] === '2') {
                    unset(
                        $row['sumber_pencemaran_pabrik'],
                        $row['sumber_pencemaran_rumah_tangga'],
                        $row['sumber_pencemaran_lain'],
                        $row['dampak_kesehatan'],
                        $row['dampak_lainnya']
                    );
                }
                break;

            case 'transaksi_bencana_alam_p7_rt':
                if (isset($row['kejadian']) && (string) $row['kejadian'] === '2') {
                    unset(
                        $row['jml_kejadian'],
                        $row['korban_jiwa'],
                        $row['pengungsi'],
                        $row['warga_terdampak']
                    );
                }
                break;

            case 'transaksi_klb_p9_rt':
                if (isset($row['kejadian']) && (string) $row['kejadian'] === '2') {
                    unset($row['jml_penderita'], $row['jml_meninggal']);
                }
                break;

            case 'rt_p11':
                if (isset($row['ada_pos_polisi'])) {
                    if ((string) $row['ada_pos_polisi'] === '1') {
                        unset($row['jarak_ke_pos_polisi_terdekat']);
                    } elseif ((string) $row['ada_pos_polisi'] === '2') {
                        unset($row['jumlah_pos_polisi_digunakan'], $row['jumlah_pos_polisi_tidak_digunakan']);
                    }
                }
                break;
        }

        return $row;
    }

    /**
     * Hapus record progress jika kuesioner dihapus.
     */
    public function recordDelete(string $idParent, string $formCode, ?string $idSurvey = null): void
    {
        $idSurvey = $idSurvey ?? self::getActiveSurvey()?->id;

        $query = SurveyProgress::where('id_parent', $idParent)
            ->where('form_code', $formCode);
        if ($idSurvey) {
            $query->where('id_survey', $idSurvey);
        }
        $query->delete();
    }

    /**
     * Ambil seluruh progress kuesioner milik satu parent (1 query cepat).
     */
    public function getProgressMap(string $idParent, ?string $idSurvey = null): Collection
    {
        $idSurvey = $idSurvey ?? self::getActiveSurvey()?->id;

        $query = SurveyProgress::where('id_parent', $idParent);
        if ($idSurvey) {
            $query->where('id_survey', $idSurvey);
        }
        return $query->get()->keyBy(fn ($item) => strtoupper($item->form_code));
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
        ?SurveyProgress $cached = null,
        ?string $idSurvey = null
    ): array {
        $idSurvey = $idSurvey ?? self::getActiveSurvey()?->id;

        try {
            // Cek keberadaan baris fisik di database sesuai survey aktif
            $query = DB::table($table)->where($parentColumn, $idParent);
            if ($idSurvey && Schema::hasColumn($table, 'id_survey')) {
                $query->where('id_survey', $idSurvey);
            }
            $hasRecord = $query->exists();

            if (!$hasRecord) {
                // Self-healing: jika record fisik terhapus/belum ada di survei ini, pastikan cache survey_progress di-reset ke 0
                if ($cached && ($cached->skor_wajib > 0 || $cached->skor_total > 0)) {
                    $cached->update(['skor_wajib' => 0, 'skor_total' => 0, 'status_verifikasi' => 'belum_diisi']);
                }
                return ['skor_wajib' => 0, 'skor_total' => 0, 'status_verifikasi' => 'belum_diisi'];
            }

            // Validasi master table: pastikan jumlah baris terisi sesuai jumlah master sebelum menganggap selesai
            $formUpper = strtoupper($formCode);
            $isMasterTable = isset(self::MASTER_TABLE_MAP[$formUpper]);
            if ($isMasterTable) {
                $totalMaster = DB::table(self::MASTER_TABLE_MAP[$formUpper])->count();
                if ($query->count() < $totalMaster) {
                    $cached = null; // Re-sync to reflect partial progress
                }
            }

            // Jika record fisik ada dan sudah di-cache sebagai selesai sempurna (100%), gunakan nilai cache
            if ($cached && $cached->skor_wajib === 100 && $cached->skor_total === 100) {
                return [
                    'skor_wajib' => (int) $cached->skor_wajib,
                    'skor_total' => (int) $cached->skor_total,
                    'status_verifikasi' => $cached->status_verifikasi ?? 'terverifikasi',
                ];
            }

            // Jika belum dihitung kelengkapannya, jalankan sinkronisasi
            $synced = $this->syncProgress($idParent, $formCode, $table, $parentColumn, [], $idSurvey);
            return [
                'skor_wajib' => (int) $synced->skor_wajib,
                'skor_total' => (int) $synced->skor_total,
                'status_verifikasi' => $synced->status_verifikasi ?? ($synced->skor_wajib == 100 ? 'terverifikasi' : 'belum_diisi'),
            ];
        } catch (\Throwable $e) {
            Log::error("Error getOrSyncProgress [{$formCode}] parent [{$idParent}]: " . $e->getMessage());
            return [
                'skor_wajib' => (int) ($cached->skor_wajib ?? 0),
                'skor_total' => (int) ($cached->skor_total ?? 0),
                'status_verifikasi' => $cached->status_verifikasi ?? 'belum_diisi',
            ];
        }
    }

    /**
     * Ambil survey aktif saat ini berdasarkan tanggal hari ini.
     * Jika tidak ada yang aktif pas di rentang tanggal, ambil survey terbaru.
     */
    public static function getActiveSurvey()
    {
        $today = \Carbon\Carbon::today()->toDateString();
        $active = \App\Models\Survey\Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if (!$active) {
            $active = \App\Models\Survey\Survey::orderBy('tgl_akhir', 'desc')->first();
        }

        return $active;
    }

    /**
     * Hitung statistik tingkat pendataan untuk level tertentu (RT, Keluarga, dll).
     *
     * @param string $level 'rt' | 'keluarga'
     * @return array
     */
    public function getLevelDashboardStats(string $level = 'rt'): array
    {
        $level = strtolower($level);
        $activeSurvey = self::getActiveSurvey();
        $idSurvey = $activeSurvey?->id;

        if ($level === 'keluarga' || $level === 'kg') {
            $requiredForms = ['P4', 'P4.21', 'P4.22', 'P4.23', 'P4.24'];
            $totalTarget = DB::table('kg_p2')->count();
        } elseif ($level === 'individu' || $level === 'idv') {
            $level = 'individu';
            $requiredForms = ['P2', 'P204', 'P4', 'P401', 'P402', 'P5'];
            $totalTarget = DB::table('individu_p1')->count();
        } else {
            // Default RT
            $level = 'rt';
            $requiredForms = [
                'P2', 'P5', 'P502', 'P508', 'P6', 'P607', 'P609',
                'P7', 'P706', 'P709', 'P713', 'P8', 'P801', 'P901',
                'P902', 'P10', 'P1004', 'P1009', 'P11', 'P1101', 'P1102'
            ];
            $totalTarget = DB::table('rt_p4')->count();
        }

        // Entitas target yang sudah 100% instrumennya terverifikasi
        $completedParents = DB::table('survey_progress')
            ->when($idSurvey, fn($q) => $q->where('id_survey', $idSurvey))
            ->whereIn('form_code', $requiredForms)
            ->where('status_verifikasi', 'terverifikasi')
            ->groupBy('id_parent')
            ->havingRaw('COUNT(DISTINCT form_code) >= ?', [count($requiredForms)])
            ->pluck('id_parent');

        $statCompleted = $completedParents->count();

        // Entitas target yang sudah mulai diisi/ditarik tapi belum 100% lengkap/terverifikasi
        $inProgressParents = DB::table('survey_progress')
            ->when($idSurvey, fn($q) => $q->where('id_survey', $idSurvey))
            ->whereIn('form_code', $requiredForms)
            ->where(function ($q) {
                $q->where('skor_wajib', '>', 0)
                  ->orWhere('skor_total', '>', 0)
                  ->orWhere('status_verifikasi', '!=', 'belum_diisi');
            })
            ->whereNotIn('id_parent', $completedParents)
            ->distinct('id_parent')
            ->pluck('id_parent');

        $statIncomplete = $inProgressParents->count();
        $statNotStarted = max(0, $totalTarget - $statCompleted - $statIncomplete);
        $progressPercent = $totalTarget > 0 ? (int) round(($statCompleted / $totalTarget) * 100) : 0;

        $desa = DB::table('desa_p2')->select('nama_desa')->first();
        $lokasi = $desa?->nama_desa ? $desa->nama_desa . ', Jogoroto' : 'Sumbermulyo, Jogoroto';

        return [
            'level' => $level,
            'statTotal' => $totalTarget,
            'statCompleted' => $statCompleted,
            'statIncomplete' => $statIncomplete,
            'statNotStarted' => $statNotStarted,
            'progressPercent' => $progressPercent,
            'lokasi' => $lokasi,
            'survey' => [
                'id' => $idSurvey,
                'nama' => $activeSurvey?->nama_survey,
                'tahun' => $activeSurvey?->tahun_survey,
            ],
        ];
    }
}
