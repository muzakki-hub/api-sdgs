<?php

namespace App\Models\RT\P7;

use App\Models\Master\MasterLingkunganRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiPencemaranP7RTM extends Model
{
    use HasFactory;

    protected $table = 'transaksi_pencemaran_p7_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'id_master_lingkungan',

        'pencemaran',
        'sumber_pencemaran_pabrik',
        'sumber_pencemaran_rumah_tangga',
        'sumber_pencemaran_lain',
        'lokasi_limbah',
        'pengaduan_warga',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

        public function masterLingkungan()
    {
        return $this->belongsTo(MasterLingkunganRTM::class, 'id_master_lingkungan');
    }
}
