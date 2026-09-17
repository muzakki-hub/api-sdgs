<?php

namespace App\Models\Desa\P9;

use Illuminate\Database\Eloquent\Model;

class P9 extends Model
{
    protected $table = 'desa_p9';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        // 'id_desa_p2',
        'id_survey',
        'nama_bumdes',
        'email',
        'web_bumdes',
        'fb_bumdes',
        'twitter_bumdes',
        'alamat_desa',
        'yt_bumdes',
        'modal_awal',
        'omset_setahun',
        'keuntungan_bersih',
        'keuntungan_kotor',
        'aset_bumdes',
        'sumbangan_padesa',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    public function p914()
    {
        return $this->hasMany(P914::class, 'id_desa_p9', 'id');
    }
    public function p923()
    {
        return $this->hasMany(P923::class, 'id_desa_p9', 'id');
    }
    public function p932()
    {
        return $this->hasMany(P932::class, 'id_desa_p9', 'id');
    }
    public function p941()
    {
        return $this->hasMany(P932::class, 'id_desa_p9', 'id');
    }
}
