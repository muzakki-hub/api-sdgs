<?php

namespace App\Models\RT\P10;

use App\Models\Master\MasterLembagaMasyarakatRTM;
use Illuminate\Database\Eloquent\Model;

class TransaksiLembagaMasyarakatP10RTM extends Model
{
    use \App\Models\Traits\HasSurveyVerification;

    protected $table = 'transaksi_lembaga_masyarakat_p10_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'is_verified',
        'id',
        'id_survey',
        'id_master_lembaga_masyarakat',
        'id_p4',

        'jumlah_kelompok',
        'jumlah_pengurus',
        'jumlah_anggota',
        'fasilitas',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];



    public function masterLembagaMasyarakat()
    {
        return $this->belongsTo(MasterLembagaMasyarakatRTM::class, 'id_master_lembaga_masyarakat');
    }
}
