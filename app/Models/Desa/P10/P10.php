<?php

namespace App\Models\Desa\P10;

use Illuminate\Database\Eloquent\Model;

class P10 extends Model
{
    protected $table = 'desa_p10';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
 
    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'sarana_yg_digunakan',
        'sarana_transportasi',
        'angkutan_umum',
        'angkutan_umum_utama',
        'jarak_tempuh',
        'waktu_tempuh',
        'biaya',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
