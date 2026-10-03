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
        Schema::table('kg_p2', function (Blueprint $table) {
            if (!Schema::hasColumn('kg_p2', 'nik_kk')) {
                $table->string('nik_kk', 25)->nullable()->after('no_kk')->comment('NIK kepala keluarga');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kg_p2', function (Blueprint $table) {
            if (Schema::hasColumn('kg_p2', 'nik_kk')) {
                $table->dropColumn('nik_kk');
            }
        });
    }
};
