<?php

namespace App\Models\Desa\P4;

use Illuminate\Database\Eloquent\Model;

class P4 extends Model
{
    protected $table = 'desa_p4';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'bulan_ke',
        'agenda_musyawarah', 
        'tgl_musyawarah', 
        // 'dokumen_musyawarah',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
