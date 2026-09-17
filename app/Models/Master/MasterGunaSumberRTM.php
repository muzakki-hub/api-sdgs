<?php

namespace App\Models\Master;

use App\Models\RT\P7\TransaksiGunaSumberP7RTM;
use Illuminate\Database\Eloquent\Model;

class MasterGunaSumberRTM extends Model
{
    protected $table = 'master_guna_sumber_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_penggunaan',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiGunaSumberP7RTM::class, 'id_master_guna_sumber');
    }
}
