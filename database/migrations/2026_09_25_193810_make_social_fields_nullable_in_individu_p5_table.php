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
        Schema::table('individu_p5', function (Blueprint $table) {
            $table->integer('kerja_bakti')->nullable()->change();
            $table->integer('siskampling')->nullable()->change();
            $table->integer('pesta_rakyat')->nullable()->change();
            $table->integer('menolong_kematian')->nullable()->change();
            $table->integer('menolong_sakit')->nullable()->change();
            $table->integer('menolong_kecelakaan')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('individu_p5', function (Blueprint $table) {
            $table->integer('kerja_bakti')->nullable(false)->change();
            $table->integer('siskampling')->nullable(false)->change();
            $table->integer('pesta_rakyat')->nullable(false)->change();
            $table->integer('menolong_kematian')->nullable(false)->change();
            $table->integer('menolong_sakit')->nullable(false)->change();
            $table->integer('menolong_kecelakaan')->nullable(false)->change();
        });
    }
};
