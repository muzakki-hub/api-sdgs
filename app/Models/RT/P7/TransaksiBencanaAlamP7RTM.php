<?php

namespace App\Models\RT\P7;

use App\Models\Master\MasterBencanaAlamRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiBencanaAlamP7RTM extends Model
{
    use HasFactory;

    protected $table = 'transaksi_bencana_alam_p7_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_bencana_alam',
        'id_p4',

        'kejadian',
        'jml_kejadian',
        'korban_jiwa',
        'pengungsi',
        'warga_terdampak',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function masterBencanaAlam()
    {
        return $this->belongsTo(MasterBencanaAlamRTM::class, 'id_master_bencana_alam');
    }
}
