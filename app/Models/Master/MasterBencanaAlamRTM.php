<?php

namespace App\Models\Master;

use App\Models\RT\P7\TransaksiBencanaAlamP7RTM;
use Illuminate\Database\Eloquent\Model;

class MasterBencanaAlamRTM extends Model
{
    protected $table = 'master_bencana_alam_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_bencana',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiBencanaAlamP7RTM::class, 'id_master_bencana_alam');
    }
}
