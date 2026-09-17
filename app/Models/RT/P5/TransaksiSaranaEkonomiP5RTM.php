<?php

namespace App\Models\RT\P5;

use App\Models\Master\MasterSaranaEkonomiRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiSaranaEkonomiP5RTM extends Model
{
      use HasFactory;

    protected $table = 'transaksi_sarana_ekonomi_p5_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'id_master_sarana_ekonomi',
        'jumlah',
        'kondisi',
        'jarak_sarana',
        'kemudahan_mencapai',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterSaranaEkonomi()
    {
        return $this->belongsTo(MasterSaranaEkonomiRTM::class, 'id_master_sarana_ekonomi');
    }
}
