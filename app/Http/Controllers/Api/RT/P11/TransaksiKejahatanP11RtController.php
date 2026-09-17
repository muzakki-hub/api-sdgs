<?php

namespace App\Http\Controllers\Api\RT\P11;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RT\P11\TransaksiKejahatanP11RTM;

class TransaksiKejahatanP11RtController extends Controller
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
            'id_p4' => 'required|string|max:25',
            'id_master_kejahatan' => 'required|string|max:25',

            'jumlah_kasus' => 'required|integer',
            'jumlah_selesai' => 'required|integer',
            'jumlah_tidak_ditangani' => 'required|integer',
            'korban_luka' => 'required|integer',
            'korban_tewas' => 'required|integer',
        ]);

        $id = 'P1102-' . strtotime(now());

        try {
            TransaksiKejahatanP11RTM::create(array_merge($validated, [
                'id'         => $id,
                'id_survey' => $survey->id,
                'id_buat' => $userId,
                'id_update' => $userId,
'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

                        app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'],
                'P1102',
                'transaksi_kejahatan_p11_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P1102 RT berhasil disimpan',
                'id' => $id,
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P1102: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterKejahatan)
    {
        $now = Carbon::now();

        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $data = TransaksiKejahatanP11RTM::where('id_p4', $idP4)
            ->where('id_master_kejahatan', $idMasterKejahatan)->where('id_survey', $survey->id)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1102 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
            'data' => $data,
        ]);
    }

    public function update(Request $request, $id)
    {
        $now = Carbon::now();

        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $data = TransaksiKejahatanP11RTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1102 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',
            'id_master_kejahatan' => 'required|string|max:25',

            'jumlah_kasus' => 'required|integer',
            'jumlah_selesai' => 'required|integer',
            'jumlah_tidak_ditangani' => 'required|integer',
            'korban_luka' => 'required|integer',
            'korban_tewas' => 'required|integer',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P1102 berhasil diperbarui',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P1102: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterKejahatan)
    {
        $data = TransaksiKejahatanP11RTM::where('id_p4', $idP4)
            ->where('id_master_kejahatan', $idMasterKejahatan)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1102 tidak ditemukan',
            ], 404);
        }

        try {
                        $surveyId = $data->id_survey ?? $survey?->id;
            $data->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P1102',
                'transaksi_kejahatan_p11_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P1102 berhasil dihapus',
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P1102: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiKejahatanP11RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P1102', 'transaksi_kejahatan_p11_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P1102 berhasil dihapus',
        ], 200);
    }
}
