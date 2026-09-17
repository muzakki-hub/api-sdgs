<?php

namespace App\Models\Desa\P6;

use Illuminate\Database\Eloquent\Model;

class P601 extends Model
{
    protected $table = 'desa_p601';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'anggaran_pendapatan',
        'apbn',
        'pades',
        'pajak_daerah',
        'alokasi_dana_desa',
        'apbd_prov',
        'apbd_kab',
        'hibah',
        'lain_lain',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
