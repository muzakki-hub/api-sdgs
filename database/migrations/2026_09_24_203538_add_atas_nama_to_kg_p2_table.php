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
            if (!Schema::hasColumn('kg_p2', 'atas_nama')) {
                $table->string('atas_nama', 100)->nullable()->after('daya_meteran_rumah')->comment('Meteran atas nama siapa');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kg_p2', function (Blueprint $table) {
            if (Schema::hasColumn('kg_p2', 'atas_nama')) {
                $table->dropColumn('atas_nama');
            }
        });
    }
};
