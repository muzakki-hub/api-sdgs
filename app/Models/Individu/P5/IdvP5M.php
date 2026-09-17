<?php

namespace App\Models\Individu\P5;

use App\Models\Individu\P1\IdvP1M;
use Illuminate\Database\Eloquent\Model;

class IdvP5M extends Model
{
    protected $table = 'individu_p5';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_individu_p1',
        'pendidikan_terakhir',
        'pendidikan_terakhir_lainnya',
        'bahasa_rumah',
        'bahasa_formal',
        'kerja_bakti',
        'siskampling',
        'pesta_rakyat',
        'menolong_kematian',
        'menolong_sakit',
        'menolong_kecelakaan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    public function getPendidikanTerakhirTextAttribute()
    {
        return match ($this->pendidikan_terakhir) {
            '1' => 'Tidak Sekolah',
            '2' => 'SD/Sederajat',
            '3' => 'SMP/Sederajat',
            '4' => 'SMA/Sederajat',
            '5' => 'Diploma 1-3',
            '6' => 'S1/Sederajat',
            '7' => 'S2/Sederajat',
            '8' => 'S3/Sederajat',
            '9' => 'Pesantren',
            '10' => 'Lainnya',
            default => '-',
        };
    }
}
