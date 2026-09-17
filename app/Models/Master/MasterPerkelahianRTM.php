<?php

namespace App\Models\Master;

use App\Models\RT\P11\TransaksiPerkelahianP11RTM;
use Illuminate\Database\Eloquent\Model;

class MasterPerkelahianRTM extends Model
{
    protected $table = 'master_perkelahian_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_perkelahian',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiPerkelahianP11RTM::class, 'id_master_perkelahian');
    }
}
