<?php

namespace App\Models\Desa\P9;

use Illuminate\Database\Eloquent\Model;

class P941 extends Model
{
    protected $table = 'desa_p941';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_survey',
        'unit_usaha_bumdes',
        'jml_unit_usaha',
        'jml_pekerja',
        'keuntungan_bersih',
        'omset_thn_lalu',
        'aset_thn_lalu',
        'id_desa_p9',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
    public function p9()
    {
        return $this->belongsTo(P9::class, 'id_desa_p9', 'id');
    }
}
