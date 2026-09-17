<?php

namespace App\Models\RT\P6;

use App\Models\Master\MasterOperatorSinyalRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiOperatorSinyalP6RTM extends Model
{
     use HasFactory;

    protected $table = 'transaksi_operator_sinyal_p6_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'id_master_operator_sinyal',
        'jenis_sinyal_1',
        'jenis_sinyal_2',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterOperatorSinyal()
    {
        return $this->belongsTo(MasterOperatorSinyalRTM::class, 'id_master_operator_sinyal');
    }
}
