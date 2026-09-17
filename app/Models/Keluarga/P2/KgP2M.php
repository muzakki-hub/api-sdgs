<?php

namespace App\Models\Keluarga\P2;

use Illuminate\Database\Eloquent\Model;
use App\Models\Survey\Survey;
use App\Models\Wilayah;

class KgP2M extends Model
{
    protected $table = 'kg_p2';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'id_survey',
        'kode_provinsi',
        'kode_kabupaten',
        'kode_kecamatan',
        'kode_desa',
        'rt',
        'rw',
        'nama_kpl_keluarga',
        'nik_kk',
        'no_kk',
        'alamat',
        'no_hp',
        'telp_rumah',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update'
    ];

    /**
     * Relasi ke tabel P3 (Deskripsi Keluarga)
     * Satu lokasi (P2) bisa punya banyak keluarga (P3)
     */
    public function p3()
    {
        return $this->hasMany(\App\Models\Keluarga\P3\KgP3M::class, 'id_kg_p2', 'id');
    }
    public function p4()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP4M::class, 'id_kg_p2', 'id');
    }
    public function p421()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP421M::class, 'id_kg_p2', 'id');
    }
    public function p422()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP422M::class, 'id_kg_p2', 'id');
    }
    public function p423()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP423M::class, 'id_kg_p2', 'id');
    }
    public function p424()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP424M::class, 'id_kg_p2', 'id');
    }

    /**
     * Scope untuk filter berdasarkan kode wilayah (optional)
     */
    public function scopeWilayah($query, $kodeDesa = null, $kodeKecamatan = null)
    {
        if ($kodeDesa) {
            $query->where('kode_desa', $kodeDesa);
        }
        if ($kodeKecamatan) {
            $query->where('kode_kecamatan', $kodeKecamatan);
        }
        return $query;
    }

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }
    public function provinsi()
    {
        return $this->belongsTo(Wilayah::class, 'kode_provinsi', 'kode');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Wilayah::class, 'kode_kabupaten', 'kode');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Wilayah::class, 'kode_kecamatan', 'kode');
    }

    public function desa()
    {
        return $this->belongsTo(Wilayah::class, 'kode_desa', 'kode');
    }
}
