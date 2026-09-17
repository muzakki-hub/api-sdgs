<?php

namespace App\Models\RT\P11;

use Illuminate\Database\Eloquent\Model;

class RtP11M extends Model
{
     protected $table = 'rt_p11';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',

        'jumlah_kegiatan_poskamling',
        'jumlah_kegiatan_regu_keamanan',
        'jumlah_tambahan_hansip',

        'pelaporan_tamu',
        'inisiatif_siskamling',

        'jumlah_anggota_linmas',

        'ada_pos_polisi',
        'jumlah_pos_polisi_digunakan',
        'jumlah_pos_polisi_tidak_digunakan',
        'jarak_ke_pos_polisi_terdekat',
        'kemudahan_akses_pos_polisi',

        'jumlah_korban_bunuh_diri',
        'jumlah_lokasi_anak_jalanan',
        'jumlah_tempat_gelandangan_pengemis',
        'jumlah_lokasi_psk',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
