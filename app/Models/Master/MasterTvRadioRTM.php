<?php

namespace App\Models\Master;

use App\Models\RT\P6\TransaksiTvRadioP6RTM;
use Illuminate\Database\Eloquent\Model;

class MasterTvRadioRTM extends Model
{
    protected $table = 'master_tv_radio_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'program_tv_radio',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
     public function transaksi()
    {
        return $this->hasMany(TransaksiTvRadioP6RTM::class, 'id_master_tv_radio');
    }
}
