<?php

namespace App\Models\Keluarga\P4;

use Illuminate\Database\Eloquent\Model;

class KgP4M extends Model
{
    protected $table = 'kg_p4';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_kg_p2',
        'tempat_tinggal_yg_ditempati',
        'status_lahan_tempat_tinggal_yg_ditempati',
        'luas_lantai_ttl_terluas',
        'luas_lahan_ttl_terluas',
        'jns_lantai_ttl_terluas',
        'dinding_sebagian_besar_rumah',
        'jendela',
        'atap',
        'penerangan_rumah',
        'energi_untuk_memasak',
        'sumber_kayu_bakar',
        'tempat_pembuangan_sampah',
        'fasilitas_mck',
        'sumber_air_mandi',
        'fasilitas_bab',
        'sumber_air_minum',
        'tmpt_pembuangan_limbah_cair',
        'rumah_berada_dibawah',
        'rumah_di_bantaran_sungai',
        'rumah_dilereng_bukit_gunung',
        'secara_keseluruhan_kondisi_rumah',
        'blt_dana_desa',
        'pkh',
        'bst',
        'banpres',
        'bantuan_umkm',
        'bantuan_pekerja',
        'bantuan_anak',
        'lainnya',
        'id_survey',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke tabel P2 (Deskripsi Lokasi)
     * Setiap data permukiman terkait dengan satu lokasi keluarga (P2)
     */
    public function p2()
    {
        return $this->belongsTo(\App\Models\Keluarga\P2\KgP2M::class, 'id_kg_p2', 'id');
    }
 
    /**
     * Relasi ke tabel pendidikan (kg_p421)
     * Satu permukiman bisa punya banyak akses pendidikan
     */
    public function pendidikan()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP421M::class, 'id_kg_p2', 'id_kg_p2');
    }

    /**
     * Relasi ke tabel fasilitas kesehatan (kg_p422)
     */
    public function faskes()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP422M::class, 'id_kg_p2', 'id_kg_p2');
    }

    /**
     * Relasi ke tabel tenaga kesehatan (kg_p423)
     */
    public function nakes()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP423M::class, 'id_kg_p2', 'id_kg_p2');
    }

    /**
     * Relasi ke tabel sarana transportasi (kg_p424)
     */
    public function transportasi()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP424M::class, 'id_kg_p2', 'id_kg_p2');
    }
}
