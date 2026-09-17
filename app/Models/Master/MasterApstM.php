<?php
 
namespace App\Models\Master;

use App\Models\Keluarga\P4\KgP424M;
use Illuminate\Database\Eloquent\Model;

class MasterApstM extends Model
{
        protected $table = 'master_akses_sarpras_kg';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama_akses',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];


    public function p421()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP424M::class, 'id_master_akses_sarpras','id');
    }
     public function transaksi()
    {
        return $this->hasMany(KgP424M::class, 'id_master_akses_sarpras');
    }
}
