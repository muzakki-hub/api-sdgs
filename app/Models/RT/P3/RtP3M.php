<?php

namespace App\Models\RT\P3;
use App\Models\Survey\Survey;

use Illuminate\Database\Eloquent\Model;

class RtP3M extends Model
{
    protected $table = 'rt_p3';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'kode_provinsi',
        'kode_kabupaten',
        'kode_kecamatan',
        'kode_desa',
        'nama_desa',
        'nama_rw',
        'nama_dusun',
        'nama_ket_rw',
        'nik_ket_rw',
        'hp_ket_rw',
        'tahun_jabat_ket_rw',
        'nama_sek_rw',
        'nik_sek_rw',
        'hp_sek_rw',
        'tahun_jabat_sek_rw',
        'nama_bend_rw',
        'nik_bend_rw',
        'hp_bend_rw',
        'tahun_jabat_bend_rw',
        'id_survey',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
  public function survey()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }
}
