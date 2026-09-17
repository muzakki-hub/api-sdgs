<?php

namespace App\Models\RT\P5;

use App\Models\Master\MasterJenisIndustriRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiIndustriP5RTM extends Model
{
    use HasFactory;

    protected $table = 'transaksi_industri_p5_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    // protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_jenis_industri',
        'id_p4',
        'jml_industri_kecil',
        'jml_industri_sedang',
        'jml_menejemen',
        'jml_pekerja',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // Relasi ke master_jenis_industri
    public function jenisIndustri()
    {
        return $this->belongsTo(MasterJenisIndustriRTM::class, 'id_master_jenis_industri');
    }
}