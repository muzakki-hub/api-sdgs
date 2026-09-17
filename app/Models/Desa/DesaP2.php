<?php

namespace App\Models\Desa;

use Illuminate\Database\Eloquent\Model;
use App\Models\Survey\Survey;
use App\Models\Wilayah;

class DesaP2 extends Model
{
    protected $table = 'desa_p2';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_survey',
        'kode_provinsi',
        'kode_kabupaten',
        'kode_kecamatan',
        'kode_desa',
        'nama_desa',
        'email',
        'url_web',
        'url_facebook',
        'url_twitter',
        'url_instagram',
        'url_youtube',
        'status_pemerintahan',
        'jml_rw',
        'jml_rt',
        'no_sk_pendirian_desa',
        'tgl_sk_pendirian_desa',
        'no_sk_peta_desa',
        'tgl_sk_peta_desa',
        'luas_wilayah',
        'lokasi_desa',
        'topografi',
        'jml_warga',
        'balai_desa',
        'kepemilikan',
        'lokasi_balai_desa',
        'tempat_pemerintah_desa',
        'jam_kerja',
        'mulai_pukul',
        'akhir_pukul',
        'lintang',
        'bujur',
        // 'jenis_koordinat',
        'ketinggian_lok',
        'pjg_garis_pantai',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }
    public function provinsi()
    {
        return $this->belongsTo(Wilayah::class, 'kode_provinsi', 'kode');
    }

    public function kabupaten()
    {
        return $this->belongsTo(Wilayah::class, 'kode_kabupaten', 'kode');
    }

    public function kecamatan()
    {
        return $this->belongsTo(Wilayah::class, 'kode_kecamatan', 'kode');
    }

    public function desa()
    {
        return $this->belongsTo(Wilayah::class, 'kode_desa', 'kode');
    }
}
