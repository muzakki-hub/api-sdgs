<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('individu_p1', function (Blueprint $table) {
            if (!Schema::hasColumn('individu_p1', 'status_hubungan_keluarga')) {
                $table->string('status_hubungan_keluarga', 50)->nullable()->after('nama')->comment('Status hubungan dalam keluarga (Dukcapil)');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individu_p1', function (Blueprint $table) {
            if (Schema::hasColumn('individu_p1', 'status_hubungan_keluarga')) {
                $table->dropColumn('status_hubungan_keluarga');
            }
        });
    }
};
