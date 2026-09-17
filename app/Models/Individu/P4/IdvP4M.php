<?php

namespace App\Models\Individu\P4;

use Illuminate\Database\Eloquent\Model;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P4\IdvP401M;
use App\Models\Individu\P4\IdvP402M;

class IdvP4M extends Model
{
    protected $table = 'individu_p4';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_individu_p1',

        // Kolom disabilitas
        'tunanetra',
        'tunarungu',
        'tunawicara',
        'tunarungu_wicara',   // ← Kolom baru, sudah ditambahkan
        'tunadaksa',
        'tunagrahita',
        'tunalaras',
        'cacat_eks_sakitkusta',
        'cacat_ganda',
        'dipasung',

        // Metadata pembuat & update
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke tabel P1 (individu_p1)
     */
    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    /**
     * Relasi ke tabel P401 (penyakit)
     */
    public function penyakit()
    {
        return $this->hasMany(IdvP401M::class, 'id_individu_p4', 'id');
    }

    /**
     * Relasi ke tabel P402 (kesehatan)
     */
    public function kesehatan()
    {
        return $this->hasMany(IdvP402M::class, 'id_individu_p4', 'id');
    }

    /**
     * Helper status enum (1=Ya, 2=Tidak)
     */
    public function getStatusText($value)
    {
        return $value == '1' ? 'Ya' : 'Tidak';
    }
}
