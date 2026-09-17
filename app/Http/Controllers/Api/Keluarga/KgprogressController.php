<?php

namespace App\Http\Controllers\Api\Keluarga;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KgprogressController extends Controller
{
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
                'total_field' => 27,
            ],
            [
                'option'      => 'P4.21',
                'description' => 'Akses Fasilitas Pendidikan',
                'select'      => true,
                'table'       => 'kg_p421',
                'total_field' => 9,
            ],
            [
                'option'      => 'P4.22',
                'description' => 'Akses Fasilitas Kesehatan',
                'select'      => true,
                'table'       => 'kg_p422',
                'total_field' => 10,
            ],
            [
                'option'      => 'P4.23',
                'description' => 'Akses Tenaga Medis',
                'select'      => true,
                'table'       => 'kg_p423',
                'total_field' => 5,
            ],
            [
                'option'      => 'P4.24',
                'description' => 'Akses Sarana Prasarana',
                'select'      => true,
                'table'       => 'kg_p424',
                'total_field' => 6,
            ],
        ];

        $result = [];

        foreach ($options as $opt) {
            $table = $opt['table'];
            $skor = 0;

            $records = DB::table($table)->where('id_kg_p2', $idP2)->get();

            if ($records->isNotEmpty()) {
                $totalFilled = 0;
                foreach ($records as $record) {
                    $totalFilled += $this->countFilledFields((array) $record);
                }

                $totalExpected = $records->count() * $opt['total_field'];
                if ($totalExpected > 0) {
                    $persen = round(($totalFilled / $totalExpected) * 100);
                    $skor = min(100, $persen);
                } else {
                    $skor = 100;
                }
            }

            $result[] = [
                'option'      => $opt['option'],
                'description' => $opt['description'],
                'select'      => $opt['select'],
                'total_skor'  => $skor,
            ];
        }

        return response()->json([
            'status' => true,
            'data'   => $result,
        ]);
    }

    /**
     * Hitung jumlah field yang terisi (tidak null, tidak kosong)
     */
    private function countFilledFields(array $row): int
    {
        $excludedKeys = ['id', 'id_kg_p2', 'id_survey', 'id_buat', 'id_update', 'tgl_buat', 'tgl_update'];
        $count = 0;

        foreach ($row as $key => $val) {
            if (in_array($key, $excludedKeys, true)) {
                continue;
            }

            if ($val !== null && $val !== '' && $val !== 0 && $val !== '0') {
                $count++;
            }
        }

        return $count;
    }
}
