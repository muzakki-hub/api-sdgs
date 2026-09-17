<?php

namespace App\Models\RT\P7;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RtP7M extends Model
{

      use HasFactory;

    protected $table = 'rt_p7';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'lhn_sawah_irigasi',
        'lhn_sawah_nonirigasi',
        'lhn_kebun',
        'lhn_huma',
        'lhn_tambak',
        'lhn_kolam',
        'lhn_gembala',
        'lhn_perkebunan',
        'lhn_hutan',
        'lhn_non_sawah',
        'lhn_tambang',
        'lhn_perumahan',
        'lhn_perkantoran',
        'lhn_pertokoan',
        'lhn_industri',
        'lhn_fasum',
        'lhn_lain',
        'nama_sungai',
        'nama_danau',
        'jml_mata_air',
        'jml_embung',
        'limbah_industri',
        'limbah_rumah_tangga',
        'limbah_lain',
        'lokasi_limbah',
        'daur_ulang_sampah',
        'bakar_ladang',
        'lokasi_penggalian_c',
        'sistem_peringatan_dini',
        'sistem_tsunami',
        'perlengkapan_keselamatan',
        'rambu_jalur_evakuasi',
        'normalisasi_sumber_air',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update'
    ];
}
