<?php

namespace App\Models\RT\P9;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\MasterKesehatanRTM;

class TransaksiKesehatanP9RTM extends Model
{
    protected $table = 'transaksi_kesehatan_p9_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_kesehatan',
        'id_p4',

        'nama_sarana',
        'pemilik',
        'jml_dokter',
        'jml_bidan',
        'jml_tenaga_kesehatan',
        'jml_pegawai_lain',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterKesehatan()
    {
        return $this->belongsTo(MasterKesehatanRTM::class, 'id_master_kesehatan');
    }
}
