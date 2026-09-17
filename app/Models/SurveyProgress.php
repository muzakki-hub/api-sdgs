<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyProgress extends Model
{
    protected $table = 'survey_progress';

    protected $fillable = [
        'id_parent',
        'form_code',
        'id_survey',
        'skor_wajib',
        'skor_total',
        'status_verifikasi',
    ];

    protected $casts = [
        'skor_wajib' => 'integer',
        'skor_total' => 'integer',
    ];
}
