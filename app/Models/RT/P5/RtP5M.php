<?php

namespace App\Models\RT\P5;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RtP5M extends Model
{
    use HasFactory;

    protected $table = 'rt_p5';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',

        'jml_pt_tki',
        'jml_orang_tki',

        'jml_sentra_industri',
        'jml_lik',
        'jml_pik',

        'ada_tempat_hiburan',
        'jarak_tempat_hiburan',

        'ada_pangkalan_minyak',
        'ada_pangkalan_lpg',

        'jml_kud',
        'jml_kud_tani',
        'jml_kud_kredit',
        'jml_kud_lain',
        'jml_kopinkra',
        'jml_kospin',
        'jml_koperasi_serbausaha',
        'jml_koperasi_lain',

        'kios_kud',
        'kios_bumdes',
        'kios_lain',

        'kur',
        'kkpe',
        'kuk',
        'kube',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
