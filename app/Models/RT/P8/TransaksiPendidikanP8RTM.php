<?php

namespace App\Models\RT\P8;

use App\Models\Master\MasterPendidikanM;
use App\Models\Master\MasterPendidikanRTM;
use Illuminate\Database\Eloquent\Model;

class TransaksiPendidikanP8RTM extends Model
{

    protected $table = 'transaksi_pendidikan_p8_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_pendidikan',
        'id_p4',
        'nama_pendidikan',
        'pemilik',
        'kondisi_bangunan',
        'jml_guru',
        'jml_murid',
        'jml_pegawai',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update'
    ];

     public function masterPendidikan()
    {
        return $this->belongsTo(MasterPendidikanRTM::class, 'id_master_pendidikan');
    }
}

