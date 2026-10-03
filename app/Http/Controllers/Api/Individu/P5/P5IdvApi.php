<?php

namespace App\Http\Controllers\Api\Individu\P5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P5\IdvP5M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class P5IdvApi extends Controller
{
    public function index()
    {
        $data = IdvP5M::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        $today = Carbon::now();

        // $validated = $request->validate([
        //     'kondisi_pekerjaan' => 'required',
        //     'pekerjaan_utama' => 'required',
        //     'jsk' => 'required',
        // ]);

        $data = IdvP5M::create([
            'id' => "IDVP5-" . strtotime(date("Y-m-d H:i:s")),
            'id_individu_p1' => $request->id_individu_p1,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pendidikan_terakhir_lainnya' => $request->pendidikan_terakhir_lainnya,
            'bahasa_rumah' => $request->bahasa_rumah,
            'bahasa_formal' => $request->bahasa_formal,
            'kerja_bakti' => ($request->kerja_bakti !== null && $request->kerja_bakti !== '') ? $request->kerja_bakti : null,
            'siskampling' => ($request->siskampling !== null && $request->siskampling !== '') ? $request->siskampling : null,
            'pesta_rakyat' => ($request->pesta_rakyat !== null && $request->pesta_rakyat !== '') ? $request->pesta_rakyat : null,
            'menolong_kematian' => ($request->menolong_kematian !== null && $request->menolong_kematian !== '') ? $request->menolong_kematian : null,
            'menolong_sakit' => ($request->menolong_sakit !== null && $request->menolong_sakit !== '') ? $request->menolong_sakit : null,
            'menolong_kecelakaan' => ($request->menolong_kecelakaan !== null && $request->menolong_kecelakaan !== '') ? $request->menolong_kecelakaan : null,

            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $request->id_individu_p1,
            'P5',
            'individu_p5',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P5 berhasil disimpan',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = IdvP5M::where('id', $id)->orWhere('id_individu_p1', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P5 berhasil di Tampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $today = Carbon::now();
            $record = IdvP5M::where('id', $id)->orWhere('id_individu_p1', $id)->first();

            if ($record) {
                $record->update([
                    'pendidikan_terakhir' => $request->pendidikan_terakhir,
                    'pendidikan_terakhir_lainnya' => $request->pendidikan_terakhir_lainnya,
                    'bahasa_rumah' => $request->bahasa_rumah,
                    'bahasa_formal' => $request->bahasa_formal,
                    'kerja_bakti' => ($request->kerja_bakti !== null && $request->kerja_bakti !== '') ? $request->kerja_bakti : null,
                    'siskampling' => ($request->siskampling !== null && $request->siskampling !== '') ? $request->siskampling : null,
                    'pesta_rakyat' => ($request->pesta_rakyat !== null && $request->pesta_rakyat !== '') ? $request->pesta_rakyat : null,
                    'menolong_kematian' => ($request->menolong_kematian !== null && $request->menolong_kematian !== '') ? $request->menolong_kematian : null,
                    'menolong_sakit' => ($request->menolong_sakit !== null && $request->menolong_sakit !== '') ? $request->menolong_sakit : null,
                    'menolong_kecelakaan' => ($request->menolong_kecelakaan !== null && $request->menolong_kecelakaan !== '') ? $request->menolong_kecelakaan : null,
                    'id_update' => Auth::user()->id,
                    'tgl_update' => $today
                ]);
                $idP1 = $record->id_individu_p1;
            } else {
                $idP1 = $request->id_individu_p1 ?? $id;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P5',
                'individu_p5',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data Individu P5 berhasil di update',
                'data' => $record
            ]);
        } catch (\Exception $e) {
            Log::error('Gagal update P5', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            return response()->json([
                'status' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($id)
    {
        $record = IdvP5M::where('id', $id)->orWhere('id_individu_p1', $id)->first();
        $idP1 = $record ? $record->id_individu_p1 : $id;

        if ($record) {
            $record->delete();
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P5',
            'individu_p5',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => "Data Individu P5 Berhasil Dihapus"
        ]);
    }

    public function showByIdP1($id)
    {
        $data = IdvP5M::where('id_individu_p1', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P5 berdasarkan ID P1',
            'data' => $data
        ]);
    }
}
