<?php

namespace App\Models\Master;

use App\Models\RT\P6\TransaksiOperatorSinyalP6RTM;
use Illuminate\Database\Eloquent\Model;

class MasterOperatorSinyalRTM extends Model
{
    protected $table = 'master_operator_sinyal_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama_operator',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiOperatorSinyalP6RTM::class, 'id_master_operator_sinyal');
    }
}
