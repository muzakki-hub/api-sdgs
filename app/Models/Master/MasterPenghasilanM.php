<?php

namespace App\Models\Master;

use App\Models\Individu\P2\IdvP204M;
use Illuminate\Database\Eloquent\Model;

class MasterPenghasilanM extends Model
{
    protected $table = 'master_penghasilan_idv';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'nama_komoditas',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function p421()
    {
        return $this->hasMany(\App\Models\Individu\P2\IdvP204M::class, 'id_master_penghasilan', 'id');
    }
        public function transaksi()
    {
        return $this->hasMany(IdvP204M::class, 'id_master_penghasilan');
    }
}
