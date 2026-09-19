<?php

namespace App\Services;

use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SurveyCopyService
{
    /**
     * Cari survei sebelumnya (survei yang paling baru selesai sebelum survei aktif).
     */
    public static function getPreviousSurvey(?Survey $activeSurvey = null): ?Survey
    {
        $activeSurvey = $activeSurvey ?? SurveyProgressService::getActiveSurvey();
        if (!$activeSurvey) {
            return null;
        }

        return Survey::where('id', '!=', $activeSurvey->id)
            ->where(function ($q) use ($activeSurvey) {
                $q->where('tgl_akhir', '<=', $activeSurvey->tgl_mulai)
                  ->orWhere('tgl_akhir', '<', $activeSurvey->tgl_akhir);
            })
            ->orderBy('tgl_akhir', 'desc')
            ->first();
    }

    /**
     * Salin data kuesioner RT dari survei sebelumnya ke survei aktif.
     */
    public function copyRtData(string $idP4, ?string $userId = null): array
    {
        $activeSurvey = SurveyProgressService::getActiveSurvey();
        if (!$activeSurvey) {
            return ['status' => false, 'message' => 'Saat ini tidak memasuki periode survei manapun.'];
        }

        $prevSurvey = self::getPreviousSurvey($activeSurvey);
        if (!$prevSurvey) {
            return ['status' => false, 'message' => 'Tidak ditemukan data survei sebelumnya untuk ditarik.'];
        }

        $userId = $userId ?? Auth::id() ?? 'SYSTEM';
        $now = now();
        $totalCopied = 0;

        // Daftar tabel single-record RT
        $singleTables = [
            'rt_p2' => ['code' => 'P2', 'prefix' => 'RTP2'],
            'rt_p5' => ['code' => 'P5', 'prefix' => 'RTP5'],
            'rt_p6' => ['code' => 'P6', 'prefix' => 'RTP6'],
            'rt_p7' => ['code' => 'P7', 'prefix' => 'RTP7'],
            'rt_p8' => ['code' => 'P8', 'prefix' => 'RTP8'],
            'rt_p10' => ['code' => 'P10', 'prefix' => 'RTP10'],
            'rt_p11' => ['code' => 'P11', 'prefix' => 'RTP11'],
        ];

        // Daftar tabel multi-record RT
        $multiTables = [
            'transaksi_industri_p5_rt' => ['code' => 'P502', 'prefix' => 'P502', 'uniqueCol' => 'id_master_jenis_industri'],
            'transaksi_sarana_ekonomi_p5_rt' => ['code' => 'P508', 'prefix' => 'P508', 'uniqueCol' => 'id_master_sarana_ekonomi'],
            'transaksi_operator_sinyal_p6_rt' => ['code' => 'P607', 'prefix' => 'P607', 'uniqueCol' => 'id_master_operator_sinyal'],
            'transaksi_tv_p6_rt' => ['code' => 'P609', 'prefix' => 'P609', 'uniqueCol' => 'id_master_tv_radio'],
            'transaksi_guna_sumber_p7_rt' => ['code' => 'P706', 'prefix' => 'P706', 'uniqueCol' => 'id_master_guna_sumber'],
            'transaksi_pencemaran_p7_rt' => ['code' => 'P709', 'prefix' => 'P709', 'uniqueCol' => 'id_master_lingkungan'],
            'transaksi_bencana_alam_p7_rt' => ['code' => 'P713', 'prefix' => 'P713', 'uniqueCol' => 'id_master_bencana_alam'],
            'transaksi_pendidikan_p8_rt' => ['code' => 'P801', 'prefix' => 'P801', 'uniqueCol' => 'id_master_pendidikan'],
            'transaksi_kesehatan_p9_rt' => ['code' => 'P901', 'prefix' => 'P901', 'uniqueCol' => 'id_master_kesehatan'],
            'transaksi_klb_p9_rt' => ['code' => 'P902', 'prefix' => 'P902', 'uniqueCol' => 'id_master_klb'],
            'rt_p1004' => ['code' => 'P1004', 'prefix' => 'P1004', 'uniqueCol' => 'nama_lembaga'],
            'transaksi_lembaga_masyarakat_p10_rt' => ['code' => 'P1009', 'prefix' => 'P1009', 'uniqueCol' => 'id_master_lembaga_masyarakat'],
            'transaksi_perkelahian_p11_rt' => ['code' => 'P1101', 'prefix' => 'P1101', 'uniqueCol' => 'id_master_perkelahian'],
            'transaksi_kejahatan_p11_rt' => ['code' => 'P1102', 'prefix' => 'P1102', 'uniqueCol' => 'id_master_kejahatan'],
        ];

        DB::beginTransaction();
        try {
            // Salin single-record
            foreach ($singleTables as $table => $cfg) {
                // Cek apakah sudah ada di survei aktif
                $exists = DB::table($table)->where('id_p4', $idP4)->where('id_survey', $activeSurvey->id)->exists();
                if ($exists) continue;

                $prevRow = DB::table($table)->where('id_p4', $idP4)->where('id_survey', $prevSurvey->id)->first();
                if ($prevRow) {
                    $data = (array) $prevRow;
                    $data['id'] = $cfg['prefix'] . '-' . strtotime(now()) . rand(100, 999);
                    $data['id_survey'] = $activeSurvey->id;
                    $data['is_verified'] = 0;
                    $data['id_buat'] = $userId;
                    $data['id_update'] = $userId;
                    $data['tgl_buat'] = $now;
                    $data['tgl_update'] = $now;
                    DB::table($table)->insert($data);
                    $totalCopied++;
                }
            }

            // Salin multi-record
            foreach ($multiTables as $table => $cfg) {
                $prevRows = DB::table($table)->where('id_p4', $idP4)->where('id_survey', $prevSurvey->id)->get();
                foreach ($prevRows as $prevRow) {
                    $uniqueVal = $cfg['uniqueCol'] ? ($prevRow->{$cfg['uniqueCol']} ?? null) : null;
                    // Cek duplikasi di survei aktif
                    $query = DB::table($table)->where('id_p4', $idP4)->where('id_survey', $activeSurvey->id);
                    if ($uniqueVal && $cfg['uniqueCol']) {
                        $query->where($cfg['uniqueCol'], $uniqueVal);
                    }
                    if ($query->exists()) continue;

                    $data = (array) $prevRow;
                    $data['id'] = $cfg['prefix'] . '-' . strtotime(now()) . rand(100, 999);
                    $data['id_survey'] = $activeSurvey->id;
                    $data['is_verified'] = 0;
                    $data['id_buat'] = $userId;
                    $data['id_update'] = $userId;
                    $data['tgl_buat'] = $now;
                    $data['tgl_update'] = $now;
                    DB::table($table)->insert($data);
                    $totalCopied++;
                }
            }

            DB::commit();

            // Sync progress seluruh form RT
            $progressService = app(SurveyProgressService::class);
            foreach ($singleTables as $table => $cfg) {
                $progressService->syncProgress($idP4, $cfg['code'], $table, 'id_p4', [], $activeSurvey->id);
            }
            foreach ($multiTables as $table => $cfg) {
                $progressService->syncProgress($idP4, $cfg['code'], $table, 'id_p4', [], $activeSurvey->id);
            }

            return [
                'status' => true,
                'message' => "Berhasil menarik {$totalCopied} data instrumen RT dari survei sebelumnya ({$prevSurvey->deskripsi}).",
                'total_copied' => $totalCopied,
                'source_survey' => $prevSurvey->id,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[SurveyCopyService RT] " . $e->getMessage());
            return ['status' => false, 'message' => 'Gagal menarik data: ' . $e->getMessage()];
        }
    }

    /**
     * Salin data kuesioner Keluarga dari survei sebelumnya ke survei aktif.
     */
    public function copyKeluargaData(string $idP2, ?string $userId = null): array
    {
        $activeSurvey = SurveyProgressService::getActiveSurvey();
        if (!$activeSurvey) {
            return ['status' => false, 'message' => 'Saat ini tidak memasuki periode survei manapun.'];
        }

        $prevSurvey = self::getPreviousSurvey($activeSurvey);
        if (!$prevSurvey) {
            return ['status' => false, 'message' => 'Tidak ditemukan data survei sebelumnya untuk ditarik.'];
        }

        $userId = $userId ?? Auth::id() ?? 'SYSTEM';
        $now = now();
        $totalCopied = 0;

        DB::beginTransaction();
        try {
            // 1. kg_p3
            if (!DB::table('kg_p3')->where('id_kg_p2', $idP2)->where('id_survey', $activeSurvey->id)->exists()) {
                $prevP3 = DB::table('kg_p3')->where('id_kg_p2', $idP2)->where('id_survey', $prevSurvey->id)->first();
                if ($prevP3) {
                    $d = (array) $prevP3;
                    $d['id'] = 'KG-' . strtotime(now()) . rand(100, 999);
                    $d['id_survey'] = $activeSurvey->id;
                    $d['is_verified'] = 0;
                    $d['id_buat'] = $userId;
                    $d['id_update'] = $userId;
                    $d['tgl_buat'] = $now;
                    $d['tgl_update'] = $now;
                    DB::table('kg_p3')->insert($d);
                    $totalCopied++;
                }
            }

            // 2. kg_p4
            if (!DB::table('kg_p4')->where('id_kg_p2', $idP2)->where('id_survey', $activeSurvey->id)->exists()) {
                $prevP4 = DB::table('kg_p4')->where('id_kg_p2', $idP2)->where('id_survey', $prevSurvey->id)->first();
                if ($prevP4) {
                    $d = (array) $prevP4;
                    $d['id'] = 'KGP4-' . strtotime(now()) . rand(100, 999);
                    $d['id_survey'] = $activeSurvey->id;
                    $d['is_verified'] = 0;
                    $d['id_buat'] = $userId;
                    $d['id_update'] = $userId;
                    $d['tgl_buat'] = $now;
                    $d['tgl_update'] = $now;
                    DB::table('kg_p4')->insert($d);
                    $totalCopied++;
                }
            }

            // 3. Sub-indikator keluarga (kg_p421, kg_p422, kg_p423, kg_p424)
            $subTables = [
                'kg_p421' => ['master' => 'id_master_pendidikan', 'code' => 'P4.21', 'prefix' => '421_'],
                'kg_p422' => ['master' => 'id_master_faskes', 'code' => 'P4.22', 'prefix' => '422_'],
                'kg_p423' => ['master' => 'id_master_tenkes', 'code' => 'P4.23', 'prefix' => '423_'],
                'kg_p424' => ['master' => 'id_master_akses_sarpras', 'code' => 'P4.24', 'prefix' => '424_'],
            ];

            foreach ($subTables as $table => $cfg) {
                $prevRows = DB::table($table)->where('id_kg_p2', $idP2)->where('id_survey', $prevSurvey->id)->get();
                foreach ($prevRows as $prevRow) {
                    $masterVal = $prevRow->{$cfg['master']};
                    if (DB::table($table)->where('id_kg_p2', $idP2)->where('id_survey', $activeSurvey->id)->where($cfg['master'], $masterVal)->exists()) {
                        continue;
                    }
                    $d = (array) $prevRow;
                    $d['id'] = substr($cfg['prefix'] . md5($idP2 . $masterVal . $activeSurvey->id), 0, 25);
                    $d['id_survey'] = $activeSurvey->id;
                    $d['is_verified'] = 0;
                    $d['id_buat'] = $userId;
                    $d['id_update'] = $userId;
                    $d['tgl_buat'] = $now;
                    $d['tgl_update'] = $now;
                    DB::table($table)->insert($d);
                    $totalCopied++;
                }
            }

            DB::commit();

            // Sync progress keluarga
            $progressService = app(SurveyProgressService::class);
            $progressService->syncProgress($idP2, 'P4', 'kg_p4', 'id_kg_p2', [], $activeSurvey->id);
            foreach ($subTables as $table => $cfg) {
                $progressService->syncProgress($idP2, $cfg['code'], $table, 'id_kg_p2', [], $activeSurvey->id);
            }

            return [
                'status' => true,
                'message' => "Berhasil menarik {$totalCopied} data instrumen Keluarga dari survei sebelumnya ({$prevSurvey->deskripsi}).",
                'total_copied' => $totalCopied,
                'source_survey' => $prevSurvey->id,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[SurveyCopyService Keluarga] " . $e->getMessage());
            return ['status' => false, 'message' => 'Gagal menarik data: ' . $e->getMessage()];
        }
    }

    /**
     * Salin data kuesioner Individu dari survei sebelumnya ke survei aktif.
     */
    public function copyIndividuData(string $idP1, ?string $userId = null): array
    {
        $activeSurvey = SurveyProgressService::getActiveSurvey();
        if (!$activeSurvey) {
            return ['status' => false, 'message' => 'Saat ini tidak memasuki periode survei manapun.'];
        }

        $prevSurvey = self::getPreviousSurvey($activeSurvey);
        if (!$prevSurvey) {
            return ['status' => false, 'message' => 'Tidak ditemukan data survei sebelumnya untuk ditarik.'];
        }

        $currentP1 = DB::table('individu_p1')->where('id', $idP1)->first();
        if (!$currentP1) {
            return ['status' => false, 'message' => 'Data individu tidak ditemukan.'];
        }

        $prevP1 = DB::table('individu_p1')
            ->where('id_survey', $prevSurvey->id)
            ->where(function ($q) use ($currentP1) {
                if (!empty($currentP1->nik)) {
                    $q->where('nik', $currentP1->nik);
                } else {
                    $q->where('nama', $currentP1->nama);
                }
            })
            ->first();

        if (!$prevP1) {
            return ['status' => false, 'message' => 'Tidak ditemukan data kuesioner individu pada survei sebelumnya.'];
        }

        $userId = $userId ?? Auth::id() ?? 'SYSTEM';
        $now = now();
        $totalCopied = 0;

        $singleTables = [
            'individu_p2' => ['code' => 'P2', 'prefix' => 'IDVP2'],
            'individu_p4' => ['code' => 'P4', 'prefix' => 'IDVP4'],
            'individu_p5' => ['code' => 'P5', 'prefix' => 'IDVP5'],
        ];

        $multiTables = [
            'individu_p204' => ['code' => 'P204', 'prefix' => 'IDVP204', 'uniqueCol' => 'id_master_penghasilan'],
            'individu_p401' => ['code' => 'P401', 'prefix' => 'IDVP401', 'uniqueCol' => 'id_master_penyakit'],
            'individu_p402' => ['code' => 'P402', 'prefix' => 'IDVP402', 'uniqueCol' => 'id_master_sarkes'],
        ];

        DB::beginTransaction();
        try {
            foreach ($singleTables as $table => $cfg) {
                $exists = DB::table($table)->where('id_individu_p1', $idP1)->exists();
                if ($exists) continue;

                $prevRow = DB::table($table)->where('id_individu_p1', $prevP1->id)->first();
                if ($prevRow) {
                    $data = (array) $prevRow;
                    $data['id'] = $cfg['prefix'] . '-' . strtotime(now()) . rand(100, 999);
                    $data['id_individu_p1'] = $idP1;
                    $data['id_buat'] = $userId;
                    $data['id_update'] = $userId;
                    $data['tgl_buat'] = $now;
                    $data['tgl_update'] = $now;
                    DB::table($table)->insert($data);
                    $totalCopied++;
                }
            }

            foreach ($multiTables as $table => $cfg) {
                $prevRows = DB::table($table)->where('id_individu_p1', $prevP1->id)->get();
                foreach ($prevRows as $prevRow) {
                    $uniqueVal = $cfg['uniqueCol'] ? ($prevRow->{$cfg['uniqueCol']} ?? null) : null;
                    $query = DB::table($table)->where('id_individu_p1', $idP1);
                    if ($uniqueVal && $cfg['uniqueCol']) {
                        $query->where($cfg['uniqueCol'], $uniqueVal);
                    }
                    if ($query->exists()) continue;

                    $data = (array) $prevRow;
                    $data['id'] = $cfg['prefix'] . '-' . strtotime(now()) . rand(100, 999);
                    $data['id_individu_p1'] = $idP1;
                    $data['id_buat'] = $userId;
                    $data['id_update'] = $userId;
                    $data['tgl_buat'] = $now;
                    $data['tgl_update'] = $now;
                    DB::table($table)->insert($data);
                    $totalCopied++;
                }
            }

            DB::commit();

            $progressService = app(SurveyProgressService::class);
            foreach ($singleTables as $table => $cfg) {
                $progressService->syncProgress($idP1, $cfg['code'], $table, 'id_individu_p1');
            }
            foreach ($multiTables as $table => $cfg) {
                $progressService->syncProgress($idP1, $cfg['code'], $table, 'id_individu_p1');
            }

            return [
                'status' => true,
                'message' => "Berhasil menarik {$totalCopied} data instrumen Individu dari survei sebelumnya ({$prevSurvey->deskripsi}).",
                'total_copied' => $totalCopied,
                'source_survey' => $prevSurvey->id,
            ];
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[SurveyCopyService Individu] " . $e->getMessage());
            return ['status' => false, 'message' => 'Gagal menarik data: ' . $e->getMessage()];
        }
    }
}

