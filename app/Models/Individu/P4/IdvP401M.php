<?php

namespace App\Models\Individu\P4;

use App\Models\Individu\P1\IdvP1M;
use App\Models\Master\MasterPenyakitM;
use Illuminate\Database\Eloquent\Model;

class IdvP401M extends Model
{
    protected $table = 'individu_p401';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_individu_p1',
        'id_master_penyakit',
        'status',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // ============================
    // RELASI KE TABEL INDUK P1
    // ============================
    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    // ============================
    // RELASI KE MASTER PENYAKIT
    // ============================
    public function masterPenyakit()
    {
        return $this->belongsTo(MasterPenyakitM::class, 'id_master_penyakit', 'id');
    }

    // ============================
    // ACCESSOR STATUS
    // ============================
    public function getStatusTextAttribute()
    {
        return $this->status == '1' ? 'Ya' : 'Tidak';
    }
}
