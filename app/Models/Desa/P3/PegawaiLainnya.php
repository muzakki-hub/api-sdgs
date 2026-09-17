<?php

namespace App\Models\Desa\P3;

use Illuminate\Database\Eloquent\Model;

class PegawaiLainnya extends Model
{
    protected $table = 'desa_pegawai_lainnya';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'pegawai_ke',
        'nik_pegawai_desa',
        'nama_pegawai_desa',
        'hp_pegawai_desa',
        'awal_jabatan_pegawai_desa',
        'id_desa_p3',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function p3()
    {
        return $this->belongsTo(\App\Models\Desa\P3\P3::class, 'id_desa_p3', 'id');
    }
}
