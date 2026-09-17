<?php

namespace App\Models\Desa\P9;

use Illuminate\Database\Eloquent\Model;

class P923 extends Model
{
    protected $table = 'desa_p923';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_survey',
        'pengawas_ke',
        'nama_pengawas',
        'nik_pengawas',
        'hp_pengawas',
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
