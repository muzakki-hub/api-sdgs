<?php

namespace App\Models\Keluarga\P3;

use Illuminate\Database\Eloquent\Model;

class KgP3M extends Model
{
    protected $table = 'kg_p3';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'no_kk',
        'nik_kk',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke tabel P2 (Deskripsi Lokasi)
     * Banyak keluarga (P3) dimiliki oleh satu lokasi (P2)
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p2', 'id');
    }
 
    /**
     * Relasi ke tabel P4 (Permukiman)
     * Satu keluarga (P3) bisa punya satu data permukiman (P4)
     */
    public function p4()
    {
        return $this->hasOne(\App\Models\Keluarga\P4\KgP4M::class, 'id_kg_p2', 'id_kg_p2');
    }

    /**
     * Scope pencarian berdasarkan Nomor KK atau NIK
     */
    public function scopeCari($query, $keyword)
    {
        return $query->where('no_kk', 'like', "%{$keyword}%")
            ->orWhere('nik_kk', 'like', "%{$keyword}%");
    }
}
