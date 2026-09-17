<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        'kg_p4',
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
        // 1. Tambahkan status_verifikasi di survey_progress
        if (Schema::hasTable('survey_progress')) {
            Schema::table('survey_progress', function (Blueprint $table) {
                if (!Schema::hasColumn('survey_progress', 'status_verifikasi')) {
                    $table->string('status_verifikasi', 30)->default('terverifikasi')->after('skor_total');
                }
            });
        }

        // 2. Tambahkan is_verified di seluruh tabel kuesioner
        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (!Schema::hasColumn($tableName, 'is_verified')) {
                        $table->tinyInteger('is_verified')->default(1)->after('id_survey');
                    }
                });
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
                if (Schema::hasColumn('survey_progress', 'status_verifikasi')) {
                    $table->dropColumn('status_verifikasi');
                }
            });
        }

        foreach ($this->tables as $tableName) {
            if (Schema::hasTable($tableName)) {
                Schema::table($tableName, function (Blueprint $table) use ($tableName) {
                    if (Schema::hasColumn($tableName, 'is_verified')) {
                        $table->dropColumn('is_verified');
                    }
                });
            }
        }
    }
};
