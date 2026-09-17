<?php

namespace App\Models\Desa\P6;

use Illuminate\Database\Eloquent\Model;

class P603 extends Model
{
    protected $table = 'desa_p603';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'aset',
        'volume',
        'satuan_volume',
        'nilai',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
