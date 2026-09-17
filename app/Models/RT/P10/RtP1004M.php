<?php

namespace App\Models\RT\P10;

use Illuminate\Database\Eloquent\Model;

class RtP1004M extends Model
{
    protected $table = 'rt_p1004';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'id_p4',
        'nama_lembaga',
        'jml_pengurus',
        'jml_anggota',
        'fasilitas',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    // public function p4()
    // {
    //     return $this->belongsTo(RtP4M::class, 'id_rt_p4', 'id');
    // }
}
