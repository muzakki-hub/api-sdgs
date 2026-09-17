<?php

namespace App\Models\Individu\P4;

use App\Models\Individu\P1\IdvP1M;
use App\Models\Master\MasterSarkesM;
use Illuminate\Database\Eloquent\Model;

class IdvP402M extends Model
{
    protected $table = 'individu_p402';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_individu_p1',
        'id_master_sarkes',
        'jml_berkunjung',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // Relasi ke P1
    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    // Relasi ke master sarkes
    public function masterSarkes()
    {
        return $this->belongsTo(MasterSarkesM::class, 'id_master_sarkes', 'id');
    }
}
