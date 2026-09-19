<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P7\TransaksiPencemaranP7RTM;

class TransaksiPencemaranP7RtController extends Controller
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
            'id_master_lingkungan' => 'required|string|max:25',
            'pencemaran' => 'required|in:1,2',

            'sumber_pencemaran_pabrik' => 'sometimes|in:1,2',
            'sumber_pencemaran_rumah_tangga' => 'sometimes|in:1,2',
            'sumber_pencemaran_lain' => 'sometimes|in:1,2',

            'lokasi_limbah' => 'sometimes|in:1,2,3,4',
            'pengaduan_warga' => 'sometimes|in:1,2',
        ]);


        if ($validated["pencemaran"] == "2") {
            $validated['sumber_pencemaran_pabrik'] = null;
            $validated['sumber_pencemaran_rumah_tangga'] = null;
            $validated['sumber_pencemaran_lain'] = null;
            $validated['lokasi_limbah'] =  null;
            $validated['pengaduan_warga'] =  null;
        }

        try {
            $existing = TransaksiPencemaranP7RTM::where('id_p4', $validated['id_p4'])
                ->where('id_master_lingkungan', $validated['id_master_lingkungan'])
                ->where('id_survey', $survey->id)
                ->first();

            if ($existing) {
                $existing->update(array_merge($validated, [
                    'id_update' => $userId,
                    'tgl_update' => now(),
                ]));
                $id = $existing->id;
            } else {
                $id = 'P709-' . strtotime(now());
                TransaksiPencemaranP7RTM::create(array_merge($validated, [
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
                'P709',
                'transaksi_pencemaran_p7_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P709 RT berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT 709: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterLingkungan)
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

        $data = TransaksiPencemaranP7RTM::where('id_p4', $idP4)
            ->where('id_master_lingkungan', $idMasterLingkungan)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P709 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P709 ditemukan',
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
        $data = TransaksiPencemaranP7RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P709 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',
            'id_master_lingkungan' => 'required|string|max:25',
            'pencemaran' => 'required|in:1,2',
            'sumber_pencemaran_pabrik' => 'sometimes|in:1,2',
            'sumber_pencemaran_rumah_tangga' => 'sometimes|in:1,2',
            'sumber_pencemaran_lain' => 'sometimes|in:1,2',
            'lokasi_limbah' => 'sometimes|in:1,2,3,4',
            'pengaduan_warga' => 'sometimes|in:1,2',
        ]);

        if ($validated["pencemaran"] == "2") {
            $validated['sumber_pencemaran_pabrik'] = null;
            $validated['sumber_pencemaran_rumah_tangga'] = null;
            $validated['sumber_pencemaran_lain'] = null;
            $validated['lokasi_limbah'] =  null;
            $validated['pengaduan_warga'] =  null;
        }

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P709 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P709: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterLingkungan)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $surveyId = $survey?->id;

        $query = TransaksiPencemaranP7RTM::where('id_p4', $idP4)
            ->where('id_master_lingkungan', $idMasterLingkungan);

        if ($query->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P709 tidak ditemukan',
            ], 404);
        }

        try {
            $query->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P709',
                'transaksi_pencemaran_p7_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P709 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P709: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiPencemaranP7RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P709', 'transaksi_pencemaran_p7_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P709 berhasil dihapus',
        ], 200);
    }
}
