<?php

namespace App\Models\Individu\P2;
use App\Models\Individu\P1\IdvP1M;

use Illuminate\Database\Eloquent\Model;

class IdvP2M extends Model
{
    protected $table = 'individu_p2';
    protected $primaryKey = 'id';
    public $incrementing = false; // karena id bukan auto increment
    protected $keyType = 'string';
    public $timestamps = false; // karena pakai tgl_buat & tgl_update, bukan created_at & updated_at

    protected $fillable = [
        'id',
        'id_individu_p1',
        'kondisi_pekerjaan',
        'pekerjaan_utama',
        'pekerjaan_lainnya',
        'jsk',
        'id_buat',
        'id_update',
        'tgl_buat',
        'tgl_update',
    ];

    /**
     * Relasi ke tabel IndividuP1
     */
    public function individuP1()
    {
        return $this->belongsTo(IdvP1M::class, 'id_individu_p1', 'id');
    }

    /**
     * Accessor teks kondisi pekerjaan
     */
    public function getKondisiPekerjaanTextAttribute()
    {
        return match ($this->kondisi_pekerjaan) {
            '1' => 'Bersekolah',
            '2' => 'Ibu Rumah Tangga',
            '3' => 'Tidak Bekerja',
            '4' => 'Sedang Mencari Pekerjaan',
            '5' => 'Bekerja',
            default => '-',
        };
    }

    /**
     * Accessor teks pekerjaan utama
     */
    public function getPekerjaanUtamaTextAttribute()
    {
        return match ($this->pekerjaan_utama) {
            '1' => 'Petani Pemilik Lahan',
            '2' => 'Petani Penyewa',
            '3' => 'Buruh Tani',
            '4' => 'Nelayan Pemilik Kapal/Perahu',
            '5' => 'Nelayan Penyewa Kapal/Perahu',
            '6' => 'Buruh Nelayan',
            '7' => 'Guru',
            '8' => 'Guru Agama',
            '9' => 'Pedagang',
            '10' => 'Pengolahan/Industri',
            '11' => 'PNS',
            '12' => 'TNI',
            '13' => 'Perangkat Desa',
            '14' => 'Pegawai Kantor Desa',
            '15' => 'TKI',
            '16' => 'Lainnya',
            default => '-',
        };
    }

    /**
     * Accessor teks kepesertaan JSK
     */
    public function getJskTextAttribute()
    {
        return match ($this->jsk) {
            '1' => 'Peserta',
            '2' => 'Bukan Peserta',
            default => '-',
        };
    }
}
