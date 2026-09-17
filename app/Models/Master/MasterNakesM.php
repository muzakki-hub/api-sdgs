<?php

namespace App\Models\Master;

use App\Models\Keluarga\P4\KgP423M;
use Illuminate\Database\Eloquent\Model;

class MasterNakesM extends Model
{
    protected $table = 'master_tenkes_kg';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tenaga_kesehatan',
    ];


    public function p422()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP423M::class, 'id_master_tenkes', 'id');
    }
        public function transaksi()
    {
        return $this->hasMany(KgP423M::class, 'id_master_tenkes');
    }
}
