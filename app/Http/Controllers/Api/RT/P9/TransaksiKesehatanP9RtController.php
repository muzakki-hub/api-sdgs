<?php

namespace App\Http\Controllers\Api\RT\P9;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\SurveyProgressService;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterKesehatanRTM;
use App\Models\RT\P9\TransaksiKesehatanP9RTM;

class TransaksiKesehatanP9RtController extends Controller
{
    public function index($idP4)
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

        $data = TransaksiKesehatanP9RTM::with('masterKesehatan')->where('id_p4', $idP4)->where('id_survey', $survey->id)->orderBy('tgl_buat', 'desc')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada data yang tersimpan',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data
        ]);
    }

    public function store(Request $request)
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

        $userId = Auth::id() ?? $request->user()?->id ?? auth('sanctum')->id();
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $validated = $request->validate([
            'id_master_kesehatan' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'nama_sarana' => 'required|string',
            'pemilik' => 'required|in:1,2',

            'jml_dokter' => 'required|integer|min:0',
            'jml_bidan' => 'required|integer|min:0',
            'jml_tenaga_kesehatan' => 'required|integer|min:0',
            'jml_pegawai_lain' => 'required|integer|min:0',
        ]);

        $id = 'P901-' . strtotime(now());

        try {
            TransaksiKesehatanP9RTM::create(array_merge($validated, [
                'id'         => $id,
                'id_survey' => $survey->id,
                'id_buat' => $userId,
                'id_update' => $userId,
'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

                        app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'],
                'P901',
                'transaksi_kesehatan_p9_rt',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P901: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
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

        $data = TransaksiKesehatanP9RTM::find($id);
        if ($data && $data->id_survey !== $survey->id) { $data = null; }
        $dataMaster = MasterKesehatanRTM::orderBy('tgl_buat', 'desc')->get();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P901 ditemukan',
            'data' => [
                'data' => $data,
                'dataMaster' => $dataMaster
            ],
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
        $data = TransaksiKesehatanP9RTM::where('id', $id)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_master_kesehatan' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'nama_sarana' => 'required|string',
            'pemilik' => 'required|in:1,2',

            'jml_dokter' => 'required|integer|min:0',
            'jml_bidan' => 'required|integer|min:0',
            'jml_tenaga_kesehatan' => 'required|integer|min:0',
            'jml_pegawai_lain' => 'required|integer|min:0',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P901: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function destroy($id)
    {
        $data = TransaksiKesehatanP9RTM::where('id', $id)->where('id_survey', $survey->id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        try {
                        $idP4 = $data->id_p4;
            $surveyId = $data->id_survey ?? $survey?->id;
            $data->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP4,
                'P901',
                'transaksi_kesehatan_p9_rt',
                'id_p4',
                [],
                $surveyId
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P901: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $survey = SurveyProgressService::getActiveSurvey();
        $deleted = TransaksiKesehatanP9RTM::where('id_p4', $idP4)->where('id_survey', $survey?->id)->delete();
        app(\App\Services\SurveyProgressService::class)->syncProgress($idP4, 'P901', 'transaksi_kesehatan_p9_rt', 'id_p4', [], $survey?->id);

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P901 berhasil dihapus',
        ], 200);
    }
}
