<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected array $tables = [
        'rt_p2',
        'rt_p5',
        'transaksi_industri_p5_rt',
        'transaksi_sarana_ekonomi_p5_rt',
        'rt_p6',
        'transaksi_operator_sinyal_p6_rt',
        'transaksi_tv_p6_rt',
        'rt_p7',
        'transaksi_guna_sumber_p7_rt',
        'transaksi_pencemaran_p7_rt',
        'transaksi_bencana_alam_p7_rt',
        'rt_p8',
        'transaksi_pendidikan_p8_rt',
        'transaksi_kesehatan_p9_rt',
        'transaksi_klb_p9_rt',
        'rt_p10',
        'rt_p1004',
        'transaksi_lembaga_masyarakat_p10_rt',
        'rt_p11',
        'transaksi_perkelahian_p11_rt',
        'transaksi_kejahatan_p11_rt',
        'kg_p3',
        'kg_p421',
        'kg_p422',
        'kg_p423',
        'kg_p424',
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Tambah id_survey ke survey_progress & update unique index
        if (Schema::hasTable('survey_progress')) {
            Schema::table('survey_progress', function (Blueprint $table) {
                if (!Schema::hasColumn('survey_progress', 'id_survey')) {
                    $table->string('id_survey', 25)->nullable()->index()->after('form_code');
                }
            });

            // Backfill survey_progress
            DB::table('survey_progress')->whereNull('id_survey')->update(['id_survey' => 'sr-1760405009']);

            Schema::table('survey_progress', function (Blueprint $table) {
                // Drop index lama jika ada
                try {
                    $table->dropUnique('uniq_parent_form');
                } catch (\Throwable $e) {}

                // Buat unique baru mencakup id_survey
                try {
                    $table->unique(['id_parent', 'form_code', 'id_survey'], 'uniq_parent_form_survey');
                } catch (\Throwable $e) {}
            });
        }

        // 2. Tambah id_survey ke seluruh tabel kuesioner RT & Keluarga
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && !Schema::hasColumn($tableName, 'id_survey')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->string('id_survey', 25)->nullable()->index();
                });

                // Backfill seluruh data kuesioner yang sudah ada dengan survei sebelumnya
                DB::table($tableName)->whereNull('id_survey')->update(['id_survey' => 'sr-1760405009']);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (Schema::hasTable('survey_progress')) {
            Schema::table('survey_progress', function (Blueprint $table) {
                try {
                    $table->dropUnique('uniq_parent_form_survey');
                } catch (\Throwable $e) {}
                try {
                    $table->unique(['id_parent', 'form_code'], 'uniq_parent_form');
                } catch (\Throwable $e) {}
                if (Schema::hasColumn('survey_progress', 'id_survey')) {
                    $table->dropColumn('id_survey');
                }
            });
        }

        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName) && Schema::hasColumn($tableName, 'id_survey')) {
                Schema::table($tableName, function (Blueprint $table) {
                    $table->dropColumn('id_survey');
                });
            }
        }
    }
};
