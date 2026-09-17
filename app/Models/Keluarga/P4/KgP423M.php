<?php

namespace App\Models\Keluarga\P4;

use Illuminate\Database\Eloquent\Model;

class KgP423M extends Model
{
    protected $table = 'kg_p423';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'id_master_tenkes',
        'jarak',
        'waktu_tempuh',
        'kemudahan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke P2 (Deskripsi Lokasi)
     * Catatan: pada struktur DB tertulis id_kg_p1, tapi bisa dikonfirmasi jika seharusnya id_kg_p2.
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p1', 'id');
    }

    /**
     * Relasi ke master tenaga kesehatan
     * (Bidan, Dokter, Perawat, dll)
     */
    public function masterTenkes()
    {
        return $this->belongsTo(\App\Models\Master\MasterTenkesM::class, 'id_master_tenkes', 'id');
    }
}
