<?php

namespace App\Models\RT\P6;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RtP6M extends Model
{
    use HasFactory;

    protected $table = 'rt_p6';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'penerangan_jalan',
        'prasarana_transport_antar_rt',
        'pj_jalan_aspal',
        'pj_jalan_kerikil',
        'pj_jalan_tanah',
        'pj_jalan_papan',
        'pj_jalan_setapak',
        'pj_jalan_lain',
        'akses_jalan_roda_4',
        'angkutan_trayek',
        'angkutan_operasional',
        'angkutan_jam_operasional',
        'dermaga',
        'jml_bts',
        'kantor_pos',
        'pos_keliling',
        'ekspedisi_swasta',
        'jml_permukiman_liar',
        'fasum_pasar',
        'fasum_stasiun',
        'fasum_terminal',
        'fasum_jembatan',
        'fasum_pelabuhan',
        'jml_rumah_mewah',
        'jml_apartemen',
        'jml_rusun',
        'jml_boarding_school',
        'jml_kos',
        'jml_asrama_militer',
        'jml_lapas',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
