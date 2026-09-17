<?php

namespace App\Models\Master;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\RT\P11\TransaksiKejahatanP11RTM;

class MasterKejahatanRTM extends Model
{
    use HasFactory;

    protected $table = 'master_kejahatan_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_kejahatan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function transaksi()
    {
        return $this->hasMany(TransaksiKejahatanP11RTM::class, 'id_master_kejahatan');
    }
}
