<?php

namespace App\Http\Controllers\Api\RT;

use App\Http\Controllers\Controller;
use App\Services\SurveyProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RtprogressController extends Controller
{
    protected SurveyProgressService $progressService;

    public function __construct(SurveyProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    public function getProgress($idP4)
    {
        $options = [
            ['option' => 'P2', 'select' => false, 'description' => 'Deskripsi lokasi', 'table' => 'rt_p2'],
            ['option' => 'P5', 'select' => false, 'description' => 'Lembaga ekonomi', 'table' => 'rt_p5'],
            ['option' => 'P502', 'select' => true, 'description' => 'Industri menurut bahan baku utama', 'table' => 'transaksi_industri_p5_rt'],
            ['option' => 'P508', 'select' => true, 'description' => 'Sarana ekonomi yang tersedia', 'table' => 'transaksi_sarana_ekonomi_p5_rt'],
            ['option' => 'P6', 'select' => false, 'description' => 'Infrastruktur', 'table' => 'rt_p6'],
            ['option' => 'P607', 'select' => true, 'description' => 'Sinyal HP', 'table' => 'transaksi_operator_sinyal_p6_rt'],
            ['option' => 'P609', 'select' => true, 'description' => 'Program/siaran TV/radio yang diterima', 'table' => 'transaksi_tv_p6_rt'],
            ['option' => 'P7', 'select' => false, 'description' => 'Lingkungan dan bencana alam', 'table' => 'rt_p7'],
            ['option' => 'P706', 'select' => true, 'description' => 'Penggunaan sungai, irigasi, danau, embung', 'table' => 'transaksi_guna_sumber_p7_rt'],
            ['option' => 'P709', 'select' => true, 'description' => 'Pencemaran/polusi setahun terakhir', 'table' => 'transaksi_pencemaran_p7_rt'],
            ['option' => 'P713', 'select' => true, 'description' => 'Bencana alam setahun terakhir', 'table' => 'transaksi_bencana_alam_p7_rt'],
            ['option' => 'P8', 'select' => false, 'description' => 'Pendidikan', 'table' => 'rt_p8'],
            ['option' => 'P801', 'select' => true, 'description' => 'Keberadaan sarana pendidikan', 'table' => 'transaksi_pendidikan_p8_rt'],
            ['option' => 'P901', 'select' => true, 'description' => 'Kesehatan', 'table' => 'transaksi_kesehatan_p9_rt'],
            ['option' => 'P902', 'select' => true, 'description' => 'Kejadian luar biasa dan penyakit setahun terakhir', 'table' => 'transaksi_klb_p9_rt'],
            ['option' => 'P10', 'select' => false, 'description' => 'Agama sosial budaya', 'table' => 'rt_p10'],
            ['option' => 'P1004', 'select' => true, 'description' => 'Keberadaan lembaga keagamaan', 'table' => 'rt_p1004'],
            ['option' => 'P1009', 'select' => true, 'description' => 'Jumlah jenis lembaga kemasyarakatan desa', 'table' => 'transaksi_lembaga_masyarakat_p10_rt'],
            ['option' => 'P11', 'select' => false, 'description' => 'Keamanan', 'table' => 'rt_p11'],
            ['option' => 'P1101', 'select' => true, 'description' => 'Kejadian perkelahian massal setahun terakhir', 'table' => 'transaksi_perkelahian_p11_rt'],
            ['option' => 'P1102', 'select' => true, 'description' => 'Tindak kejahatan yang terjadi di desa selama setahun terakhir', 'table' => 'transaksi_kejahatan_p11_rt'],
        ];

        // 1 query cepat ke tabel survey_progress
        $progressMap = $this->progressService->getProgressMap($idP4);

        $result = [];

        foreach ($options as $opt) {
            $codeKey = strtoupper($opt['option']);
            $cached = $progressMap->get($codeKey);

            $scores = $this->progressService->getOrSyncProgress(
                $idP4,
                $opt['option'],
                $opt['table'],
                'id_p4',
                $cached
            );

            $result[] = [
                'option'      => $opt['option'],
                'description' => $opt['description'],
                'select'      => $opt['select'],
                'skor_wajib'  => $scores['skor_wajib'],
                'skor_total'  => $scores['skor_total'],
                'total_skor'  => $scores['skor_total'], // backward compatibility untuk frontend
            ];
        }

        return response()->json([
            'status' => true,
            'data'   => $result,
        ]);
    }
}
