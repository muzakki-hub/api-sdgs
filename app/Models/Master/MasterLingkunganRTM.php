<?php

namespace App\Models\Master;

use App\Models\RT\P7\TransaksiPencemaranP7RTM;
use Illuminate\Database\Eloquent\Model;

class MasterLingkunganRTM extends Model
{
    protected $table = 'master_lingkungan_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_lingkungan',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiPencemaranP7RTM::class, 'id_master_lingkungan');
    }
}
