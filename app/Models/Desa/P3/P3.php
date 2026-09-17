<?php

namespace App\Models\Desa\P3;

use Illuminate\Database\Eloquent\Model;

class P3 extends Model
{
    protected $table = 'desa_p3';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'nik_kades',
        'nama_kades',
        'hp_kades',
        'awal_jabatan_kades',
        'nik_sekdes',
        'nama_sekdes',
        'hp_sekdes',
        'awal_jabatan_sekdes',
        'nik_bendes',
        'nama_bendes',
        'hp_bendes',
        'awal_jabatan_bendes',
        'nik_kpl_tu',
        'nama_kpl_tu',
        'hp_kpl_tu',
        'awal_jabatan_kpl_tu',
        'nik_kpl_uang',
        'nama_kpl_uang',
        'hp_kpl_uang',
        'awal_jabatan_kpl_uang',
        'nik_kpl_rencana',
        'nama_kpl_rencana',
        'hp_kpl_rencana',
        'awal_jabatan_kpl_rencana',
        'nik_kepsek_pemerintahan',
        'nama_kepsek_pemerintahan',
        'hp_kepsek_pemerintahan',
        'awal_jabatan_kepsek_pemerintahan',
        'nik_kepsek_kesejahteraan',
        'nama_kepsek_kesejahteraan',
        'hp_kepsek_kesejahteraan',
        'awal_jabatan_kepsek_kesejahteraan',
        'nik_kepsek_pelayanan',
        'nama_kepsek_pelayanan',
        'hp_kepsek_pelayanan',
        'awal_jabatan_kepsek_pelayanan',
        'nik_kpl_bpd',
        'nama_kpl_bpd',
        'hp_kpl_bpd',
        'awal_jabatan_kpl_bpd',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ]; 

    public function pegawaiLainnya()
    {
        return $this->hasMany(\App\Models\Desa\P3\PegawaiLainnya::class, 'id_desa_p3', 'id');
    }
    public function bpd()
    {
        return $this->hasMany(\App\Models\Desa\P3\AnggotaBpd::class, 'id_desa_p3', 'id');
    }
}
