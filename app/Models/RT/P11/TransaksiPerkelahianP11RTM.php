<?php

namespace App\Models\RT\P11;

use App\Models\Master\MasterPerkelahianRTM;
use Illuminate\Database\Eloquent\Model;

class TransaksiPerkelahianP11RTM extends Model
{
    protected $table = 'transaksi_perkelahian_p11_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_perkelahian',
        'id_p4',
        'penyebab_utama',
        'jumlah_kejadian',
        'korban_luka',
        'korban_tewas',
        'penyelesaian',
        'pihak_pendamai',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterPerkelahian()
    {
        return $this->belongsTo(MasterPerkelahianRTM::class, 'id_master_perkelahian');
    }
}
