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
        Schema::create('survey_progress', function (Blueprint $table) {
            $table->id();
            $table->string('id_parent', 50)->index();
            $table->string('form_code', 20);
            $table->unsignedTinyInteger('skor_wajib')->default(0);
            $table->unsignedTinyInteger('skor_total')->default(0);
            $table->timestamps();

            $table->unique(['id_parent', 'form_code'], 'uniq_parent_form');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('survey_progress');
    }
};
