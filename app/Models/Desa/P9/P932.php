<?php

namespace App\Models\Desa\P9;

use Illuminate\Database\Eloquent\Model;

class P932 extends Model
{
    protected $table = 'desa_p932';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_survey',
        'direksi_ke',
        'nama_direksi',
        'nik_direksi',
        'hp_direksi',
        'id_desa_p9',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
    public function p9()
    {
        return $this->belongsTo(P9::class, 'id_desa_p9', 'id');
    }
}
