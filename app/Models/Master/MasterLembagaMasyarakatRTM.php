<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use App\Models\RT\P10\TransaksiLembagaMasyarakatP10RTM;

class MasterLembagaMasyarakatRTM extends Model
{
     protected $table = 'master_lembaga_masyarakat_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;


      protected $fillable = [
        'id',
        'nama_lembaga',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiLembagaMasyarakatP10RTM::class, 'id_master_lembaga_masyarakat');
    }
}
