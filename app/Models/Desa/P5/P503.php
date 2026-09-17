<?php

namespace App\Models\Desa\P5;

use Illuminate\Database\Eloquent\Model;

class P503 extends Model
{
    // SK Kepala Desa tahun sebelumnya
    protected $table = 'desa_p503';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_survey',
        'no_dokumen',
        'bulan',
        'tentang',
        'id_desa_p5',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function p5()
    {
        return $this->belongsTo(P5::class, 'id_desa_p5', 'id');
    }
}
