<?php

namespace App\Models\Desa\P7;

use Illuminate\Database\Eloquent\Model;

class P705 extends Model
{
    protected $table = 'desa_p705';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_survey',
        'pihak_kerjasama',
        'lingkup_kerjasama',
        'akhir_kerjasama',
        'jml_jiwa',
        'nilai_kerjasama',
        'id_desa_p7',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

     public function p7()
    {
        return $this->belongsTo(P7::class, 'id_desa_p7', 'id');
    }
}
