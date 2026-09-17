<?php

namespace App\Models\RT\P2;

use Illuminate\Database\Eloquent\Model;

class RtP2M extends Model
{
    public $timestamps = false;
    protected $table = 'rt_p2';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'rt',
        'id_p4',
        'nama_ket_rt',
        'alamat_ket_rt',
        'hp_ket_rt',
        'lokasi_rt',
        'topografi',
        'jlm_warga_puncak',
        'tanam_pohon_lahan_kritis',
        'panjang_garis_pantai',
        'perikanan_tangkap',
        'perikanan_budidaya',
        'tambak_garam',
        'wisata_bahari',
        'transportasi_umum',
        'kondisi_mangrove',
        'penanaman_mangrove',
        'jlm_warga_pesisir',
        'jlm_warga_diatas_air',
        'wilayah_desa_dlm_hutan',
        'wilayah_desa_tepi_hutan',
        'fungsi_hutan_konservasi',
        'fungsi_hutan_lindung',
        'fungsi_hutan_produksi',
        'fungsi_hutan_desa',
        'jlm_warga_dlm_hutan',
        'jlm_warga_sekitar_hutan',
        'ketergantungan_hutan',
        'reboisasi_hutan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update'
    ];
}
