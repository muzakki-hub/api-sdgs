<?php

namespace App\Models\RT\P9;

use App\Models\Master\MasterKlbRTM;
use Illuminate\Database\Eloquent\Model;

class TransaksiKlbP9RTM extends Model
{
    protected $table = 'transaksi_klb_p9_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_klb',
        'id_p4',

        'kejadian',
        'jml_penderita',
        'jml_meninggal',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterKlb()
    {
        return $this->belongsTo(MasterKlbRTM::class, 'id_master_klb');
    }
}
