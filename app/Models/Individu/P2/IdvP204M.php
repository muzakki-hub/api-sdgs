<?php

namespace App\Models\Individu\P2;

use App\Models\Individu\P1\IdvP1M;
use App\Models\Master\MasterPenghasilanM;
use Illuminate\Database\Eloquent\Model;

class IdvP204M extends Model
{
    protected $table = 'individu_p204';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_individu_p1',
        'id_master_penghasilan',
        'jumlah',
        'satuan',
        'penghasilan',
        'diekspor',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // Relasi ke tabel IndividuP2
    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    // Accessor untuk teks ekspor
    public function getDieksporTextAttribute()
    {
        return match ($this->diekspor) {
            '1' => 'Semua',
            '2' => 'Sebagian Besar',
            '3' => 'Tidak',
            default => '-',
        };
    }
    public function masterPenghasilan()
    {
        return $this->belongsTo(MasterPenghasilanM::class, 'id_master_penghasilan', 'id');
    }
}
