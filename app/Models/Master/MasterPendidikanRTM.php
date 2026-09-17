<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\RT\P8\TransaksiPendidikanP8RTM;

class MasterPendidikanRTM extends Model
{


    protected $table = 'master_pendidikan_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenjang_pendidikan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

        public function transaksi()
    {
        return $this->hasMany(TransaksiPendidikanP8RTM::class, 'id_master_pendidikan');
    }
}
