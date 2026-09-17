<?php

namespace App\Models\RT\P10;

use Illuminate\Database\Eloquent\Model;

class RtP10M extends Model
{
    protected $table = 'rt_p10';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'peserta_jamkes',
        'peserta_jamkerja',

        'jml_masjid',
        'jml_musala',
        'jml_gereja_kristen',
        'jml_gereja_katolik',
        'jml_kapel',
        'jml_pura',
        'jml_wihara',
        'jml_kelenteng',
        'jml_lain_tempat_ibadah',

        'cagar_budaya',

        'jml_keluarga_suku_terasing',
        'jml_jiwa_suku_terasing',

        'ruang_publik_terbuka',

        'kearifan_kehamilan',
        'kearifan_kelahiran',
        'kearifan_pekerjaan',
        'kearifan_alam',
        'kearifan_perkawinan',
        'kearifan_kehidupan',
        'kearifan_kematian',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // public function p4()
    // {
    //     return $this->belongsTo(RtP4M::class, 'id_p4', 'id');
    // }
}
