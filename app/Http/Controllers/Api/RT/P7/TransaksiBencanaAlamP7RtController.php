<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P7\TransaksiBencanaAlamP7RTM;

class TransaksiBencanaAlamP7RtController extends Controller
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
            'id_master_bencana_alam' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'kejadian' => 'required|in:1,2',
            'jml_kejadian' => 'sometimes|integer|min:0',
            'korban_jiwa' => 'sometimes|integer|min:0',
            'pengungsi' => 'sometimes|integer|min:0',
            'warga_terdampak' => 'sometimes|integer|min:0',
        ]);


        if ($validated["kejadian"] == "2") {
            $validated['jml_kejadian'] = null;
            $validated['korban_jiwa'] = null;
            $validated['pengungsi'] = null;
            $validated['warga_terdampak'] =  null;
        }

        try {
            $existing = TransaksiBencanaAlamP7RTM::where('id_p4', $validated['id_p4'])
                ->where('id_master_bencana_alam', $validated['id_master_bencana_alam'])
                ->where('id_survey', $survey->id)
                ->first();

            if ($existing) {
                $existing->update(array_merge($validated, [
                    'id_update' => $userId,
                    'tgl_update' => now(),
                ]));
                $id = $existing->id;
            } else {
                $id = 'P713-' . strtotime(now());
                TransaksiBencanaAlamP7RTM::create(array_merge($validated, [
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
                'P713',
                'transaksi_bencana_alam_p7_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P713 RT berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT 713: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function show($idP4, $idMasterBencanaAlam)
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

        $data = TransaksiBencanaAlamP7RTM::where('id_p4', $idP4)
            ->where('id_master_bencana_alam', $idMasterBencanaAlam)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P713 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P713 ditemukan',
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
        $data = TransaksiBencanaAlamP7RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P713 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_master_bencana_alam' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

           'kejadian' => 'required|in:1,2',
            'jml_kejadian' => 'sometimes|integer|min:0',
            'korban_jiwa' => 'sometimes|integer|min:0',
            'pengungsi' => 'sometimes|integer|min:0',
            'warga_terdampak' => 'sometimes|integer|min:0',
        ]);


        if ($validated["kejadian"] == "2") {
            $validated['jml_kejadian'] = null;
            $validated['korban_jiwa'] = null;
            $validated['pengungsi'] = null;
            $validated['warga_terdampak'] =  null;
        }

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P713 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P713: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterBencanaAlam)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $surveyId = $survey?->id;

        $query = TransaksiBencanaAlamP7RTM::where('id_p4', $idP4)
            ->where('id_master_bencana_alam', $idMasterBencanaAlam);

        if ($query->count() === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P713 tidak ditemukan',
            ], 404);
        }

        try {
            $query->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P713',
                'transaksi_bencana_alam_p7_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P713 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P713: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiBencanaAlamP7RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P713', 'transaksi_bencana_alam_p7_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P713 berhasil dihapus',
        ], 200);
    }
}
