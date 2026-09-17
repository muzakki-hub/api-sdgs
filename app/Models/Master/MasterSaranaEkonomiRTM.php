<?php

namespace App\Models\Master;

use App\Models\RT\P5\TransaksiSaranaEkonomiP5RTM;
use Illuminate\Database\Eloquent\Model;

class MasterSaranaEkonomiRTM extends Model
{
    protected $table = 'master_sarana_ekonomi_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'sarana_ekonomi',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiSaranaEkonomiP5RTM::class, 'id_master_sarana_ekonomi');
    }
}
