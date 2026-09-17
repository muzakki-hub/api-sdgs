<?php

namespace App\Models\Keluarga\P4;

use Illuminate\Database\Eloquent\Model;

class KgP421M extends Model
{
    protected $table = 'kg_p421';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'id_master_pendidikan',
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
     * Menghubungkan fasilitas pendidikan dengan lokasi keluarga
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p2', 'id');
    }

    /**
     * Relasi ke master pendidikan
     * Untuk mendapatkan nama jenjang pendidikan (PAUD, SD, SMP, dst)
     */
    public function pendidikan()
    {
        return $this->belongsTo(\App\Models\Master\MasterPendidikanM::class, 'id_master_pendidikan', 'id');
    }
}
