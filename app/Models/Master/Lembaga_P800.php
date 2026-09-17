<?php

namespace App\Models\Master;

use App\Models\Desa\P8\P8;
use Illuminate\Database\Eloquent\Model;

class Lembaga_P800 extends Model
{
    protected $table = 'master_lembaga_p800';
    protected $primaryKey = 'id_lembaga';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id_lembaga',
        'nama_lembaga',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(P8::class, 'id_lembaga');
    }
}
