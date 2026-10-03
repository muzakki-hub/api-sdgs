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
            $table->integer('rt')->nullable()->after('nama');
            $table->integer('rw')->nullable()->after('rt');
            $table->string('alamat', 100)->nullable()->after('rw');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individu_p1', function (Blueprint $table) {
            $table->dropColumn(['rt', 'rw', 'alamat']);
        });
    }
};
