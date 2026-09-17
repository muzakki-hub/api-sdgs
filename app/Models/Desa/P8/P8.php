<?php

namespace App\Models\Desa\P8;

use Illuminate\Database\Eloquent\Model;

class P8 extends Model
{
    protected $table = 'desa_p8';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'id_lembaga',
        'jml_pengurus',
        'jml_anggota',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
