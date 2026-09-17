<?php

namespace App\Models\RT\P11;

use App\Models\Master\MasterKejahatanRTM;
use Illuminate\Database\Eloquent\Model;

class TransaksiKejahatanP11RTM extends Model
{
    use \App\Models\Traits\HasSurveyVerification;

    protected $table = 'transaksi_kejahatan_p11_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'is_verified',
        'id',
        'id_survey',
        'id_master_kejahatan',
        'id_p4',
        'jumlah_kasus',
        'jumlah_selesai',
        'jumlah_tidak_ditangani',
        'korban_luka',
        'korban_tewas',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterKejahatan()
    {
        return $this->belongsTo(MasterKejahatanRTM::class, 'id_master_kejahatan');
    }
}
