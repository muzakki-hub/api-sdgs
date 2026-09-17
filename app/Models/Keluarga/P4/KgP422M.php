<?php

namespace App\Models\Keluarga\P4;

use Illuminate\Database\Eloquent\Model;

class KgP422M extends Model
{
    protected $table = 'kg_p422';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'id_master_faskes',
        'jarak',
        'waktu_tempuh',
        'kemudahan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke tabel P2 (Deskripsi Lokasi)
     * Menandakan akses fasilitas kesehatan ini milik lokasi keluarga tertentu.
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p2', 'id');
    }

    /**
     * Relasi ke master fasilitas kesehatan
     * Untuk mendapatkan nama fasilitas (Puskesmas, RS, Poskesdes, dll)
     */
    public function masterFaskes()
    {
        return $this->belongsTo(\App\Models\Master\MasterFaskesM::class, 'id_master_faskes', 'id');
    }
}
