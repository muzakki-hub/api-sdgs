<?php

namespace App\Models\Master;

use App\Models\RT\P9\TransaksiKlbP9RTM;
use Illuminate\Database\Eloquent\Model;

class MasterKlbRTM extends Model
{
    protected $table = 'master_klb_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_klb',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiKlbP9RTM::class, 'id_master_klb');
    }
}
