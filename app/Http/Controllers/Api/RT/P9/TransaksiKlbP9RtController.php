<?php

namespace App\Http\Controllers\Api\RT\P9;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RT\P9\TransaksiKlbP9RTM;

class TransaksiKlbP9RtController extends Controller
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
            'id_master_klb' => 'required|string|max:25',
            'kejadian'       => 'required|in:1,2',
            'jml_penderita'  => 'nullable|integer',
            'jml_meninggal'  => 'nullable|integer',
        ]);

        try {
            $existing = TransaksiKlbP9RTM::where('id_p4', $validated['id_p4'])
                ->where('id_master_klb', $validated['id_master_klb'])
                ->where('id_survey', $survey->id)
                ->first();

            if ($existing) {
                $existing->update(array_merge($validated, [
                    'id_update' => $userId,
                    'tgl_update' => now(),
                ]));
                $id = $existing->id;
            } else {
                $id = 'P902-' . strtotime(now());
                TransaksiKlbP9RTM::create(array_merge($validated, [
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
                'P902',
                'transaksi_klb_p9_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P902 RT berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterKlb)
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

        $data = TransaksiKlbP9RTM::where('id_p4', $idP4)
            ->where('id_master_klb', $idMasterKlb)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
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
        $data = TransaksiKlbP9RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',
            'id_master_klb' => 'required|string|max:25',
            'kejadian'       => 'required|in:1,2',
            'jml_penderita'  => 'nullable|integer',
            'jml_meninggal'  => 'nullable|integer',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P902 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterKlb)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $surveyId = $survey?->id;

        $query = TransaksiKlbP9RTM::where('id_p4', $idP4)
            ->where('id_master_klb', $idMasterKlb);

        if ($query->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
            ], 404);
        }

        try {
            $query->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P902',
                'transaksi_klb_p9_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P902 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiKlbP9RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P902', 'transaksi_klb_p9_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P902 berhasil dihapus',
        ], 200);
    }
}
