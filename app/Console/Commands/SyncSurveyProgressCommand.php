<?php

namespace App\Console\Commands;

use App\Services\SurveyProgressService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SyncSurveyProgressCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'survey:sync-progress';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sinkronisasi seluruh progress kuesioner eksisting ke tabel survey_progress';

    /**
     * Execute the console command.
     */
    public function handle(SurveyProgressService $service)
    {
        $this->info('Memulai sinkronisasi progress survei eksisting...');

        // 1. Sinkronisasi Tingkat Keluarga
        $keluargaForms = [
            ['code' => 'P4',    'table' => 'kg_p4',   'parentCol' => 'id_kg_p2'],
            ['code' => 'P4.21', 'table' => 'kg_p421', 'parentCol' => 'id_kg_p2'],
            ['code' => 'P4.22', 'table' => 'kg_p422', 'parentCol' => 'id_kg_p2'],
            ['code' => 'P4.23', 'table' => 'kg_p423', 'parentCol' => 'id_kg_p2'],
            ['code' => 'P4.24', 'table' => 'kg_p424', 'parentCol' => 'id_kg_p2'],
        ];

        $keluargaList = DB::table('kg_p2')->pluck('id');
        $this->info("Menemukan {$keluargaList->count()} entitas Keluarga (kg_p2).");

        $kgCount = 0;
        foreach ($keluargaList as $idP2) {
            foreach ($keluargaForms as $form) {
                // Cek apakah data kuesioner ada
                $exists = DB::table($form['table'])->where($form['parentCol'], $idP2)->exists();
                if ($exists) {
                    $service->syncProgress($idP2, $form['code'], $form['table'], $form['parentCol']);
                    $kgCount++;
                } else {
                    $service->recordDelete($idP2, $form['code']);
                }
            }
        }
        $this->info("Berhasil menyinkronkan {$kgCount} kuesioner Keluarga.");

        // 2. Sinkronisasi Tingkat RT
        $rtForms = [
            ['code' => 'P2',    'table' => 'rt_p2',                          'parentCol' => 'id_p4'],
            ['code' => 'P5',    'table' => 'rt_p5',                          'parentCol' => 'id_p4'],
            ['code' => 'P502',  'table' => 'transaksi_industri_p5_rt',        'parentCol' => 'id_p4'],
            ['code' => 'P508',  'table' => 'transaksi_sarana_ekonomi_p5_rt', 'parentCol' => 'id_p4'],
            ['code' => 'P6',    'table' => 'rt_p6',                          'parentCol' => 'id_p4'],
            ['code' => 'P607',  'table' => 'transaksi_operator_sinyal_p6_rt', 'parentCol' => 'id_p4'],
            ['code' => 'P609',  'table' => 'transaksi_tv_p6_rt',              'parentCol' => 'id_p4'],
            ['code' => 'P7',    'table' => 'rt_p7',                          'parentCol' => 'id_p4'],
            ['code' => 'P706',  'table' => 'transaksi_guna_sumber_p7_rt',      'parentCol' => 'id_p4'],
            ['code' => 'P709',  'table' => 'transaksi_pencemaran_p7_rt',       'parentCol' => 'id_p4'],
            ['code' => 'P713',  'table' => 'transaksi_bencana_alam_p7_rt',     'parentCol' => 'id_p4'],
            ['code' => 'P8',    'table' => 'rt_p8',                          'parentCol' => 'id_p4'],
            ['code' => 'P801',  'table' => 'transaksi_pendidikan_p8_rt',     'parentCol' => 'id_p4'],
            ['code' => 'P901',  'table' => 'transaksi_kesehatan_p9_rt',      'parentCol' => 'id_p4'],
            ['code' => 'P902',  'table' => 'transaksi_klb_p9_rt',            'parentCol' => 'id_p4'],
            ['code' => 'P10',   'table' => 'rt_p10',                         'parentCol' => 'id_p4'],
            ['code' => 'P1004', 'table' => 'rt_p1004',                       'parentCol' => 'id_p4'],
            ['code' => 'P1009', 'table' => 'transaksi_lembaga_masyarakat_p10_rt', 'parentCol' => 'id_p4'],
            ['code' => 'P11',   'table' => 'rt_p11',                         'parentCol' => 'id_p4'],
            ['code' => 'P1101', 'table' => 'transaksi_perkelahian_p11_rt',    'parentCol' => 'id_p4'],
            ['code' => 'P1102', 'table' => 'transaksi_kejahatan_p11_rt',      'parentCol' => 'id_p4'],
        ];

        $rtList = DB::table('rt_p4')->pluck('id');
        $this->info("Menemukan {$rtList->count()} entitas RT (rt_p4).");

        $rtCount = 0;
        foreach ($rtList as $idP4) {
            foreach ($rtForms as $form) {
                // Periksa apakah tabel ada di database
                $tableExists = DB::select("SHOW TABLES LIKE '{$form['table']}'");
                if (empty($tableExists)) {
                    continue;
                }

                $exists = DB::table($form['table'])->where($form['parentCol'], $idP4)->exists();
                if ($exists) {
                    $service->syncProgress($idP4, $form['code'], $form['table'], $form['parentCol']);
                    $rtCount++;
                } else {
                    $service->recordDelete($idP4, $form['code']);
                }
            }
        }
        $this->info("Berhasil menyinkronkan {$rtCount} kuesioner RT.");

        $this->info("Sinkronisasi selesai! Total record tersimpan di survey_progress: " . DB::table('survey_progress')->count());
        return Command::SUCCESS;
    }
}
