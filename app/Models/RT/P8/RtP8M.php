<?php

namespace App\Models\RT\P8;

use Illuminate\Database\Eloquent\Model;

class RtP8M extends Model
{
    use \App\Models\Traits\HasSurveyVerification;

   public $timestamps = false;
    protected $table = 'rt_p8';
    public $incrementing = false;
    protected $fillable = [
        'is_verified',
        'id',
        'id_survey',
        'id_p4',
        'perpustakaan_taman_bacaan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
