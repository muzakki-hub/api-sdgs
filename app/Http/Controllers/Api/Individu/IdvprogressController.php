<?php

namespace App\Http\Controllers\Api\Individu;

use App\Http\Controllers\Controller;
use App\Services\SurveyProgressService;
use Illuminate\Http\Request;

class IdvprogressController extends Controller
{
    protected SurveyProgressService $progressService;

    public function __construct(SurveyProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Hitung progress survei individu berdasarkan id_individu_p1 (idP1)
     * Mengembalikan status penyelesaian 6 instrumen kuesioner individu:
     * - P2   : Deskripsi Pekerjaan (individu_p2)
     * - P204 : Sumber Penghasilan Tambahan (individu_p204)
     * - P4   : Kesehatan dan Disabilitas (individu_p4)
     * - P401 : Penyakit yang Diderita (individu_p401)
     * - P402 : Fasilitas Kesehatan yang Digunakan (individu_p402)
     * - P5   : Pendidikan dan Sosial Budaya (individu_p5)
     */
    public function getProgress($idP1)
    {
        $options = [
            [
                'option'      => 'P2',
                'description' => 'Deskripsi Pekerjaan',
                'select'      => false,
                'table'       => 'individu_p2',
            ],
            [
                'option'      => 'P204',
                'description' => 'Sumber Penghasilan Tambahan',
                'select'      => true,
                'table'       => 'individu_p204',
            ],
            [
                'option'      => 'P4',
                'description' => 'Kesehatan dan Disabilitas',
                'select'      => false,
                'table'       => 'individu_p4',
            ],
            [
                'option'      => 'P401',
                'description' => 'Penyakit yang Diderita',
                'select'      => true,
                'table'       => 'individu_p401',
            ],
            [
                'option'      => 'P402',
                'description' => 'Fasilitas Kesehatan yang Digunakan',
                'select'      => true,
                'table'       => 'individu_p402',
            ],
            [
                'option'      => 'P5',
                'description' => 'Pendidikan dan Sosial Budaya',
                'select'      => false,
                'table'       => 'individu_p5',
            ],
        ];

        // 1 query cepat ke tabel survey_progress
        $progressMap = $this->progressService->getProgressMap($idP1);

        $result = [];

        foreach ($options as $opt) {
            $codeKey = strtoupper($opt['option']);
            $cached = $progressMap->get($codeKey);

            $scores = $this->progressService->getOrSyncProgress(
                $idP1,
                $opt['option'],
                $opt['table'],
                'id_individu_p1',
                $cached
            );

            $result[] = [
                'option'            => $opt['option'],
                'description'       => $opt['description'],
                'select'            => $opt['select'],
                'skor_wajib'        => $scores['skor_wajib'],
                'skor_total'        => $scores['skor_total'],
                'total_skor'        => $scores['skor_total'], // backward compatibility untuk frontend
                'status_verifikasi' => $scores['status_verifikasi'] ?? 'belum_diisi',
                'is_verified'       => ($scores['status_verifikasi'] ?? '') === 'terverifikasi' ? 1 : 0,
            ];
        }

        return response()->json([
            'status' => true,
            'data'   => $result,
        ]);
    }
}
