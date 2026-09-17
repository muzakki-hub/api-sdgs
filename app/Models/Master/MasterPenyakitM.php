<?php

namespace App\Models\Master;

use App\Models\Individu\P4\IdvP401M;
use Illuminate\Database\Eloquent\Model;

class MasterPenyakitM extends Model
{
    protected $table = 'master_penyakit_idv';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_penyakit',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];

    public function p401()
    {
        return $this->hasMany(\App\Models\Individu\P4\IdvP401M::class, 'id_master_penyakit', 'id');
    }
        public function transaksi()
    {
        return $this->hasMany(IdvP401M::class, 'id_master_penyakit');
    }
}
