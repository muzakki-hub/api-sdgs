<?php

namespace App\Models\Survey;

use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    protected $table = 'survey';
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'tgl_mulai',
        'tgl_akhir',
        'deskripsi',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];
}
 