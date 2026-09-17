<?php

namespace App\Models\Keluarga\P4;

use Illuminate\Database\Eloquent\Model;

class KgP424M extends Model
{
     protected $table = 'kg_p424';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'id_master_akses_sarpras',
        'jenis_transportasi',
        'penggunaan_transportasi',
        'waktu_tempuh',
        'biaya_sekali',
        'kemudahan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke P2 (Deskripsi Lokasi / Keluarga)
     * Catatan: di struktur masih pakai id_kg_p1,
     * bisa disesuaikan jika seharusnya id_kg_p2.
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p1', 'id');
    }

    /**
     * Relasi ke master akses transportasi (APST)
     * (misal: ojek, perahu, mobil desa, dll)
     */
    public function masterApst()
    {
        return $this->belongsTo(\App\Models\Master\MasterApstM::class, 'id_master_akses_sarpras', 'id');
    }
}
