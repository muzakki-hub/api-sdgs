<?php

namespace App\Models\RT\P6;

use App\Models\Master\MasterTvRadioRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiTvRadioP6RTM extends Model
{
     use HasFactory;

    protected $table = 'transaksi_tv_p6_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

       protected $fillable = [
        'id',
        'id_p4',
        'id_master_tv_radio',
        'diterima',
        'parabola',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

        public function masterTvRadio()
    {
        return $this->belongsTo(MasterTvRadioRTM::class, 'id_master_tv_radio');
    }
}
