<?php

namespace App\Http\Controllers\Api\RT;

use Illuminate\Http\Request;
use App\Services\ProgressService;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RtprogressController extends Controller
{
    // protected $service;

    // public function __construct(ProgressService $service)
    // {
    //     $this->service = $service;
    // }

    // // Hitung progress satu RT
    // public function progressRT(Request $request, $id_p4)
    // {
    //     $tables   = $request->input('tables', []);   // daftar tabel survey
    //     $excludes = $request->input('excludes', []); // exclude kolom per tabel
    //     $batas    = $request->input('batas', 50);

    //     return response()->json(
    //         $this->service->hitungProgressRT($id_p4, $tables, $excludes, $batas)
    //     );
    // }

    // // Hitung progress satu RW
    // public function progressRW(Request $request, $nama_rw)
    // {
    //     $tables   = $request->input('tables', []);
    //     $excludes = $request->input('excludes', []);
    //     $batas    = $request->input('batas', 50);

    //     return response()->json(
    //         $this->service->hitungProgressRW($nama_rw, $tables, $excludes, $batas)
    //     );
    // }

    public function getProgress($idP4)
    {
        $options = [
            ['option' => 'P2', 'select' => false, 'description' => 'Deskripsi lokasi', 'view' => 'skor_rt_p2'],
            ['option' => 'P5', 'select' => false, 'description' => 'Lembaga ekonomi', 'view' => null],
            ['option' => 'P502', 'select' => true, 'description' => 'Industri menurut bahan baku utama', 'view' => null,'table'=>'transaksi_industri_p5_rt'],
            ['option' => 'P508', 'select' => true, 'description' => 'Sarana ekonomi yang tersedia', 'view' => null,'table'=> 'transaksi_sarana_ekonomi_p5_rt'],
            ['option' => 'P6', 'select' => false, 'description' => 'Infrastruktur', 'view' => 'skor_rt_p6'],
            ['option' => 'P607', 'select' => true, 'description' => 'Sinyal HP', 'view' => 'skor_rt_p607'],
            ['option' => 'P609', 'select' => true, 'description' => 'Program/siaran TV/radio yang diterima', 'view' => 'skor_rt_p609'],
            ['option' => 'P7', 'select' => false, 'description' => 'Lingkungan dan bencana alam', 'view' => 'skor_rt_p7'],
            ['option' => 'P706', 'select' => true, 'description' => 'Penggunaan sungai, irigasi, danau, embung', 'view' => 'skor_rt_p706'],
            ['option' => 'P709', 'select' => true, 'description' => 'Pencemaran/polusi setahun terakhir', 'view' => 'skor_rt_p709'],
            ['option' => 'P713', 'select' => true, 'description' => 'Bencana alam setahun terakhir', 'view' => 'skor_rt_p713'],
            ['option' => 'P8', 'select' => false, 'description' => 'Pendidikan', 'view' => 'skor_rt_p8'],
            ['option' => 'P801', 'select' => true, 'description' => 'Keberadaan sarana pendidikan', 'view' => null, 'table' => 'transaksi_pendidikan_p8_rt'],
            ['option' => 'P901', 'select' => true, 'description' => 'Kesehatan', 'view' => null, 'table' => 'transaksi_kesehatan_p9_rt'],
            ['option' => 'P902', 'select' => true, 'description' => 'Kejadian luar biasa dan penyakit setahun terakhir', 'view' => null, 'table' => 'transaksi_klb_p9_rt'],
            ['option' => 'P10', 'select' => false, 'description' => 'Agama sosial budaya', 'view' => null],
            ['option' => 'P1004', 'select' => true, 'description' => 'Keberadaan lembaga keagamaan', 'view' => null, 'table' => 'rt_p1004'],
            ['option' => 'P1009', 'select' => true, 'description' => 'Jumlah jenis lembaga kemasyarakatan desa', 'view' => null, 'table' => 'transaksi_lembaga_masyarakat_p10_rt'],
            ['option' => 'P11', 'select' => false, 'description' => 'Keamanan', 'view' => null],
            ['option' => 'P1101', 'select' => true, 'description' => 'Kejadian perkelahian massal setahun terakhir', 'view' => null, 'table' => 'transaksi_perkelahian_p11_rt'],
            ['option' => 'P1102', 'select' => true, 'description' => 'Tindak kejahatan yang terjadi di desa selama setahun terakhir', 'view' => null, 'table' => 'transaksi_kejahatan_p11_rt'],
        ];

        $result = [];

        foreach ($options as $opt) {

            $skor = 0;

            if ($opt['select'] === true) {

                if (!empty($opt['view'])) {

                    $view = $opt['view'];


                    $viewExists = DB::select("SHOW TABLES LIKE '{$view}'");

                    if (!empty($viewExists)) {

                        $row = DB::table($view)
                            ->where('id_p4', $idP4)
                            ->first();

                        if ($row && isset($row->total_skor)) {
                            $skor = round($row->total_skor);
                        } else {
                            $skor = 0;
                        }
                    } else {
                        $skor = 100;
                    }
                } else {
                    $skor = 100;

                    if (!empty($opt['table'])) {
                        $hasData = DB::table($opt['table'])
                            ->where('id_p4', $idP4)
                            ->exists();

                        $skor = $hasData ? 100 : 0;
                    }
                }
            } else {

                $table = "rt_" . strtolower($opt['option']);

                // cek tabel
                $tableExists = DB::select("SHOW TABLES LIKE '{$table}'");

                if (!empty($tableExists)) {

                    $hasData = DB::table($table)
                        ->where('id_p4', $idP4)
                        ->exists();

                    $skor = $hasData ? 100 : 0;
                } else {
                    $skor = 0;
                }
            }

            $result[] = [
                'option' => $opt['option'],
                'description' => $opt['description'],
                'select' => $opt['select'],
                'total_skor' => $skor,
            ];
        }

        return response()->json([
            'status' => true,
            'data' => $result
        ]);
    }
}
