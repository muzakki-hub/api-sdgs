<?php

namespace App\Models\Master;

use App\Models\RT\P5\TransaksiIndustriP5RTM;
use Illuminate\Database\Eloquent\Model;

class MasterJenisIndustriRTM extends Model
{
    protected $table = 'master_jenis_industri_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'jenis_industri',
        'id_buat',
        'tgl_buat',
        'id_update',
        'tgl_update',
    ];
    public function transaksi()
    {
        return $this->hasMany(TransaksiIndustriP5RTM::class, 'id_master_jenis_industri');
    }
}
