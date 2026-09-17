<?php

namespace App\Models\Master;

use App\Models\Keluarga\P4\KgP421M;
use Illuminate\Database\Eloquent\Model;

class MasterPendidikanM extends Model
{
    protected $table = 'master_pendidikan_kg';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenjang_pendidikan',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];


    public function p421()
    {
        return $this->hasMany(\App\Models\Keluarga\P4\KgP421M::class, 'id_master_pendidikan', 'id');
    }
        public function transaksi()
    {
        return $this->hasMany(KgP421M::class, 'id_master_pendidikan');
    }
}
