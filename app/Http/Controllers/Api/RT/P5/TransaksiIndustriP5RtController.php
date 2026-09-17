<?php

namespace App\Http\Controllers\Api\RT\P5;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P5\TransaksiIndustriP5RTM;

class TransaksiIndustriP5RtController extends Controller
{

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

        $validated = $request->validate([
            'id_master_jenis_industri' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',
            'jml_industri_kecil' => 'required|integer',
            'jml_industri_sedang' => 'required|integer',
            'jml_menejemen' => 'required|integer',
            'jml_pekerja' => 'required|integer',
        ]);

        $id = 'P502-' . strtotime(now());

        try {
            TransaksiIndustriP5RTM::create(array_merge($validated, [
                'id'         => $id,
                'id_survey' => $survey->id,
                'id_buat' => $userId,
                'id_update' => $userId,
'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

                        app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'],
                'P502',
                'transaksi_industri_p5_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P502 RT berhasil disimpan',
                'id' => $id,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data P502 RT: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function show($idP4, $idMasterIndustri)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = TransaksiIndustriP5RTM::where('id_p4', $idP4)
            ->where('id_master_jenis_industri', $idMasterIndustri)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data  P502 RT ditemukan.',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = TransaksiIndustriP5RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $validated = $request->validate([
            'id_master_jenis_industri' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',
            'jml_industri_kecil' => 'required|integer',
            'jml_industri_sedang' => 'required|integer',
            'jml_menejemen' => 'required|integer',
            'jml_pekerja' => 'required|integer',
        ]);

        $data->update(array_merge($validated, [
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data RT P502 berhasil diperbarui',
            'data' => $data
        ], 200);
    }

    public function destroy($idP4, $idMasterIndustri)
    {

        $survey = SurveyProgressService::getActiveSurvey();
        $data = TransaksiIndustriP5RTM::where('id_p4', $idP4)
            ->where('id_master_jenis_industri', $idMasterIndustri)->where('id_survey', $survey?->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

                    $surveyId = $data->id_survey ?? $survey?->id;
            $data->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P502',
                'transaksi_industri_p5_rt',
                'id_p4',
                [],
                $surveyId
            );

        return response()->json([
            'status' => true,
            'message' => 'Data RT P502 berhasil dihapus',
        ], 200);
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiIndustriP5RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P502', 'transaksi_industri_p5_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P502 berhasil dihapus',
        ], 200);
    }
}
