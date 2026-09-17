<?php

namespace App\Models\RT\P4;

use App\Models\Survey\Survey;
use App\Models\RT\P10\RtP1004M;
use App\Models\RT\P10\RtP10M;
use App\Models\RT\P10\TransaksiLembagaMasyarakatP10RTM;
use App\Models\RT\P11\RtP11M;
use App\Models\RT\P11\TransaksiKejahatanP11RTM;
use App\Models\RT\P11\TransaksiPerkelahianP11RTM;
use App\Models\RT\P2\RtP2M;
use App\Models\RT\P5\RtP5M;
use App\Models\RT\P5\TransaksiIndustriP5RTM;
use App\Models\RT\P5\TransaksiSaranaEkonomiP5RTM;
use App\Models\RT\P6\RtP6M;
use App\Models\RT\P6\TransaksiOperatorSinyalP6RTM;
use App\Models\RT\P6\TransaksiTvRadioP6RTM;
use App\Models\RT\P7\RtP7M;
use App\Models\RT\P7\TransaksiBencanaAlamP7RTM;
use App\Models\RT\P7\TransaksiGunaSumberP7RTM;
use App\Models\RT\P7\TransaksiPencemaranP7RTM;
use App\Models\RT\P8\RtP8M;
use App\Models\RT\P8\TransaksiPendidikanP8RTM;
use App\Models\RT\P9\TransaksiKesehatanP9RTM;
use App\Models\RT\P9\TransaksiKlbP9RTM;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RtP4M extends Model
{
    use HasFactory;

    protected $table = 'rt_p4';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'rt',
        'id_p3_rw',
        'nama_ket_rt',
        'alamat_ket_rt',
        'nik_ket_rt',
        'hp_ket_rt',
        'tahun_jabat_ket_rt',
        'nama_sek_rt',
        'nik_sek_rt',
        'hp_sek_rt',
        'tahun_jabat_sek_rt',
        'nama_bend_rt',
        'nik_bend_rt',
        'hp_bend_rt',
        'tahun_jabat_bend_rt',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function rtP2M()
    {
        return $this->hasMany(RtP2M::class, 'id_p4', 'id');
    }

    // P5
    public function rtP5M()
    {
        return $this->hasMany(RtP5M::class, 'id_p4', 'id');
    }
    public function transaksiIndustriP5RTM()
    {
        return $this->hasMany(TransaksiIndustriP5RTM::class, 'id_p4', 'id');
    }
    public function transaksiSaranaEkonomiP5RTM()
    {
        return $this->hasMany(TransaksiSaranaEkonomiP5RTM::class, 'id_p4', 'id');
    }

    // P6
    public function rtP6M()
    {
        return $this->hasMany(RtP6M::class, 'id_p4', 'id');
    }
    public function transaksiOperatorSinyalP6RTM()
    {
        return $this->hasMany(TransaksiOperatorSinyalP6RTM::class, 'id_p4', 'id');
    }
    public function transaksiTvRadioP6RTM()
    {
        return $this->hasMany(TransaksiTvRadioP6RTM::class, 'id_p4', 'id');
    }

    // P7
    public function rtP7M()
    {
        return $this->hasMany(RtP7M::class, 'id_p4', 'id');
    }
    public function transaksiGunaSumberP7RTM()
    {
        return $this->hasMany(TransaksiGunaSumberP7RTM::class, 'id_p4', 'id');
    }
    public function transaksiBencanaAlamP7RTM()
    {
        return $this->hasMany(TransaksiBencanaAlamP7RTM::class, 'id_p4', 'id');
    }
    public function transaksiPencemaranP7RTM()
    {
        return $this->hasMany(TransaksiPencemaranP7RTM::class, 'id_p4', 'id');
    }

    // P8
    public function rtP8M()
    {
        return $this->hasMany(RtP8M::class, 'id_p4', 'id');
    }
    public function transaksiPendidikanP8RTM()
    {
        return $this->hasMany(TransaksiPendidikanP8RTM::class, 'id_p4', 'id');
    }

    // P9
    public function transaksiKesehatanP9RTM()
    {
        return $this->hasMany(TransaksiKesehatanP9RTM::class, 'id_p4', 'id');
    }
    public function transaksiKlbP9RTM()
    {
        return $this->hasMany(TransaksiKlbP9RTM::class, 'id_p4', 'id');
    }

    // P10
    public function rtP1004M()
    {
        return $this->hasMany(RtP1004M::class, 'id_p4', 'id');
    }
    public function rtP10M()
    {
        return $this->hasMany(RtP10M::class, 'id_p4', 'id');
    }
    public function transaksiLembagaMasyarakatP10RTM()
    {
        return $this->hasMany(TransaksiLembagaMasyarakatP10RTM::class, 'id_p4', 'id');
    }

    // P11
    public function rtP11M()
    {
        return $this->hasMany(RtP11M::class, 'id_p4', 'id');
    }
    public function transaksiKejahatanP11RTM()
    {
        return $this->hasMany(TransaksiKejahatanP11RTM::class, 'id_p4', 'id');
    }
    public function transaksiPerkelahianP11RTM()
    {
        return $this->hasMany(TransaksiPerkelahianP11RTM::class, 'id_p4', 'id');
    }

	  public function survey()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }
    // public function rtP3()
    // {
    //     return $this->belongsTo(RtP3::class, 'id_p3_rw', 'id');
    // }
}
