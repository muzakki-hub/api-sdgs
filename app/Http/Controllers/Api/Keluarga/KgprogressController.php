<?php

namespace App\Http\Controllers\Api\Keluarga;

use App\Http\Controllers\Controller;
use App\Services\SurveyProgressService;
use Illuminate\Http\Request;

class KgprogressController extends Controller
{
    protected SurveyProgressService $progressService;

    public function __construct(SurveyProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Hitung progress survei keluarga berdasarkan id_kg_p2
     * Mengembalikan status penyelesaian 5 instrumen kuesioner keluarga:
     * - P4    : Deskripsi Permukiman (kg_p4)
     * - P4.21 : Akses Fasilitas Pendidikan (kg_p421)
     * - P4.22 : Akses Fasilitas Kesehatan (kg_p422)
     * - P4.23 : Akses Tenaga Medis (kg_p423)
     * - P4.24 : Akses Sarana Prasarana (kg_p424)
     */
    public function getProgress($idP2)
    {
        $options = [
            [
                'option'      => 'P4',
                'description' => 'Deskripsi Permukiman',
                'select'      => false,
                'table'       => 'kg_p4',
            ],
            [
                'option'      => 'P4.21',
                'description' => 'Akses Fasilitas Pendidikan',
                'select'      => true,
                'table'       => 'kg_p421',
            ],
            [
                'option'      => 'P4.22',
                'description' => 'Akses Fasilitas Kesehatan',
                'select'      => true,
                'table'       => 'kg_p422',
            ],
            [
                'option'      => 'P4.23',
                'description' => 'Akses Tenaga Medis',
                'select'      => true,
                'table'       => 'kg_p423',
            ],
            [
                'option'      => 'P4.24',
                'description' => 'Akses Sarana Prasarana',
                'select'      => true,
                'table'       => 'kg_p424',
            ],
        ];

        // 1 query cepat ke tabel survey_progress
        $progressMap = $this->progressService->getProgressMap($idP2);

        $result = [];

        foreach ($options as $opt) {
            $codeKey = strtoupper($opt['option']);
            $cached = $progressMap->get($codeKey);

            $scores = $this->progressService->getOrSyncProgress(
                $idP2,
                $opt['option'],
                $opt['table'],
                'id_kg_p2',
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
