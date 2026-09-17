<?php

namespace App\Models\Master;

use App\Models\Individu\P4\IdvP402M;
use Illuminate\Database\Eloquent\Model;

class MasterSarkesM extends Model
{
    protected $table = 'master_sarkes_idv';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama_sarkes',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];

    public function p402()
    {
        return $this->hasMany(\App\Models\Individu\P4\IdvP402M::class, 'id_master_sarkes', 'id');
    }
    public function transaksi()
    {
        return $this->hasMany(IdvP402M::class, 'id_master_sarkes');
    }
}
