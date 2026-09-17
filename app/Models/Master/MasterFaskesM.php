<?php

namespace App\Models\Master;

use App\Models\Keluarga\P4\KgP422M;
use Illuminate\Database\Eloquent\Model;

class MasterFaskesM extends Model
{
    protected $table = 'master_faskes_kg';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenjang_kesehatan',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];


    public function p422()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP422M::class, 'id_master_faskes', 'id');
    }
     public function transaksi()
    {
        return $this->hasMany(KgP422M::class, 'id_master_faskes');
    }
}
