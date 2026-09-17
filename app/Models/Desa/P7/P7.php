<?php

namespace App\Models\Desa\P7;

use Illuminate\Database\Eloquent\Model;

class P7 extends Model
{
    protected $table = 'desa_p7';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'teknologi',
        'internet',
        'info_desa',
        'keuangan_desa',
        'srt_tidak_mampu',
        'blm_ektp',
        'blm_kk',
        'nama_pdesa',
        'jk_pdesa',
        'hp_pdesa',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

        public function p705()
    {
        return $this->hasMany(P705::class, 'id_desa_p7', 'id');
    }
}
