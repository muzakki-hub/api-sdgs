<?php

namespace App\Models\Desa\P5;

use Illuminate\Database\Eloquent\Model;

class P5 extends Model
{
    protected $table = 'desa_p5';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'rpjm_berlaku',
        'rkp_desa',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
    public function p501()
    {
        return $this->hasMany(P501::class, 'id_desa_p5', 'id');
    }
    public function p502()
    {
        return $this->hasMany(P502::class, 'id_desa_p5', 'id');
    }
    public function p503()
    {
        return $this->hasMany(P503::class, 'id_desa_p5', 'id');
    }
}
