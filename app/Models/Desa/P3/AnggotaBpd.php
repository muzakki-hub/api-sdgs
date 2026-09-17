<?php

namespace App\Models\Desa\P3;

use Illuminate\Database\Eloquent\Model;

class AnggotaBpd extends Model
{
    protected $table = 'desa_anggota_bpd';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'anggota_ke',
        'nik_anggota_bpd',
        'nama_anggota_bpd',
        'hp_anggota_bpd',
        'awal_jabatan_anggota_bpd',
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
