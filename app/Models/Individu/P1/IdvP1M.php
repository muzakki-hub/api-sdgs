<?php

namespace App\Models\Individu\P1;

use App\Models\Survey\Survey;

use Illuminate\Database\Eloquent\Model;

class IdvP1M extends Model
{
    protected $primaryKey = 'id';
    public $incrementing = false; 
    protected $table = 'individu_p1';

    protected $fillable = [
        'id',
        'id_survey',
        'no_kk',
        'nik',
        'nama',
        'jenis_kelamin',
        'tempat_lahir',
        'tgl_lahir',
        'status_pernikahan',
        'agama',
        'suku_bangsa',
        'warganegara',
        'no_hp',
        'no_wa',
        'url_email_pribadi',
        'url_facebook_pribadi',
        'url_twitter_pribadi',
        'url_instagram_pribadi',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update'
    ];

    public $timestamps = false;

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'id_survey');
    }
}
