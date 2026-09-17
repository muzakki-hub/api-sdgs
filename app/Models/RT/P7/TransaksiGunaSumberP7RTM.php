<?php

namespace App\Models\RT\P7;

use App\Models\Master\MasterGunaSumberRTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransaksiGunaSumberP7RTM extends Model
{
    use HasFactory;

    protected $table = 'transaksi_guna_sumber_p7_rt';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_master_guna_sumber',
        'id_p4',

        'sungai',
        'kondisi_sungai',

        'saluran_irigasi',
        'kondisi_saluran_irigasi',

        'danau',
        'kondisi_danau',

        'embung',
        'kondisi_embung',

        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

            public function masterGunaSumber()
    {
        return $this->belongsTo(MasterGunaSumberRTM::class, 'id_master_guna_sumber');
    }
}
