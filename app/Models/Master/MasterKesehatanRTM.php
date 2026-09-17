<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\RT\P9\TransaksiKesehatanP9RTM;

class MasterKesehatanRTM extends Model
{
    protected $table = 'master_kesehatan_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenjang_kesehatan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiKesehatanP9RTM::class, 'id_master_kesehatan');
    }
}
