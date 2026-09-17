<?php

namespace App\Http\Controllers\Api\Keluarga\P3;

use App\Http\Controllers\Controller;
use App\Models\Keluarga\P3\KgP3M;
use App\Services\SurveyProgressService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P3Api extends Controller
{
    public function index()
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $query = KgP3M::query();
        if ($survey) {
            $query->where('id_survey', $survey->id);
        }
        $data = $query->get();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $today = Carbon::now();
        $data = KgP3M::create([
            'id' => "KG-" . strtotime(date("Y-m-d H:i:s")),
            'id_kg_p2' => $request->id_kg_p2,
            'id_survey' => $survey->id,
            'no_kk' => $request->no_kk,
            'nik_kk' => $request->nik_kk,

            'id_buat' => $userId,
            'id_update' => $userId,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil disimpan',
            'data' => $data
        ]);
    }

    public function show($id)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $query = KgP3M::where('id', $id);
        if ($survey) {
            $query->where('id_survey', $survey->id);
        }
        $data = $query->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data keluarga tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil di Tampilkan',
            'data' => $data
        ]);
    }

    public function showByIdP2($id)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $query = KgP3M::where('id_kg_p2', $id);
        if ($survey) {
            $query->where('id_survey', $survey->id);
        }
        $data = $query->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data keluarga berdasarkan ID P2 tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berdasarkan ID P2',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $userId = Auth::id() ?? $request->user()?->id;
        $today = Carbon::now();
        $data = KgP3M::where('id', $id)->update([
            'no_kk' => $request->no_kk,
            'nik_kk' => $request->nik_kk,
            'id_update' => $userId,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data P3 keluarga berhasil di update',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        KgP3M::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Data P3 Berhasil Dihapus"
        ]);
    }
}
