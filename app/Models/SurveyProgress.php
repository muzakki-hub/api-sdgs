<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SurveyProgress extends Model
{
    protected $table = 'survey_progress';

    protected $fillable = [
        'id_parent',
        'form_code',
        'skor_wajib',
        'skor_total',
    ];

    protected $casts = [
        'skor_wajib' => 'integer',
        'skor_total' => 'integer',
    ];
}
