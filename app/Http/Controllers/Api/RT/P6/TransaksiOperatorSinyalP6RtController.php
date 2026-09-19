<?php

namespace App\Http\Controllers\Api\RT\P6;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P6\TransaksiOperatorSinyalP6RTM;

class TransaksiOperatorSinyalP6RtController extends Controller
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
            'id_master_operator_sinyal' => 'required|string|max:25',
            'jenis_sinyal_1'            => 'required|in:1,2,3,4',
            'jenis_sinyal_2' => 'required|in:1,2,3,4',
        ]);

        try {
            $existing = TransaksiOperatorSinyalP6RTM::where('id_p4', $validated['id_p4'])
                ->where('id_master_operator_sinyal', $validated['id_master_operator_sinyal'])
                ->where('id_survey', $survey->id)
                ->first();

            if ($existing) {
                $existing->update(array_merge($validated, [
                    'id_update' => $userId,
                    'tgl_update' => now(),
                ]));
                $id = $existing->id;
            } else {
                $id = 'P607-' . strtotime(now());
                TransaksiOperatorSinyalP6RTM::create(array_merge($validated, [
                    'id'         => $id,
                    'id_survey'  => $survey->id,
                    'id_buat'    => $userId,
                    'id_update'  => $userId,
                    'tgl_buat'   => now(),
                    'tgl_update' => null,
                ]));
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'],
                'P607',
                'transaksi_operator_sinyal_p6_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P607 RT berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function show($idP4, $idMasterOperatorSinyal)
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

        $data = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)
            ->where('id_master_operator_sinyal', $idMasterOperatorSinyal)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
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
        $data = TransaksiOperatorSinyalP6RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
           'id_p4' => 'required|string|max:25',
            'id_master_operator_sinyal' => 'required|string|max:25',
            'jenis_sinyal_1'            => 'required|in:1,2,3,4',
            'jenis_sinyal_2' => 'required|in:1,2,3,4',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P607 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function destroy($idP4, $idMasterOperatorSinyal)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $surveyId = $survey?->id;

        $query = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)
            ->where('id_master_operator_sinyal', $idMasterOperatorSinyal);

        if ($query->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
            ], 404);
        }

        try {
            $query->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P607',
                'transaksi_operator_sinyal_p6_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P607 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P607', 'transaksi_operator_sinyal_p6_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan ' .$idP4,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P607 berhasil dihapus',
        ], 200);
    }
}
