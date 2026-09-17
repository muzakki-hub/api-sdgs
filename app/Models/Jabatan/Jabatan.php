<?php

namespace App\Models\Jabatan;

use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    protected $table = 'jabatan';
    protected $primaryKey = 'id'; // pastikan ini ada
    public $timestamps = false;
    public $incrementing = false;
    protected $keyType = 'string';


    protected $fillable = [
        'id',
        'nama_jabatan',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
