<?php

namespace App\Models\Desa\P6;

use Illuminate\Database\Eloquent\Model;

class P602 extends Model
{
    protected $table = 'desa_p602';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'anggaran_pengeluaran',
        'penyelenggaraan_desa',
        'pembangunan_desa',
        'pemberdayaan_desa',
        'bina_masyarakat',
        'belanja_modal',
        'bumdes',
        'lainnya',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
