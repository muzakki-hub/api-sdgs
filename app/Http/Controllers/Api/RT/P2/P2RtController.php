<?php

namespace App\Http\Controllers\Api\RT\P2;

use Carbon\Carbon;
use App\Models\RT\P2\RtP2M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

class P2RtController extends Controller
{

    public function index(Request $request)
    {
        $now = Carbon::now();
        $data = DB::table("rt_p2")
            ->join("rt_p3", "rt_p2.id_p3_rw", "=", "rt_p3.id")
            ->join('survey', 'rt_p3.id_survey', '=', 'survey.id')
            ->select("rt_p2.*", "rt_p3.nama_desa", "rt_p3.nama_dusun", 'survey.tgl_mulai as survey_tgl_mulai', 'survey.tgl_akhir as survey_tgl_akhir')
            ->where('rt_p2.id_p3_rw', "=", $request->id_p3_rw)
            ->where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->orderBy('rt_p2.tgl_buat', 'desc')
            ->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada data yang tersimpan',
                'data' => [],
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
            'data' => $data,
        ]);
    }

    /**
     * Aturan validasi bersama untuk store() & update(),
     * disesuaikan dengan field.required di config JSON.
     * Hanya `topografi` yang required:true di config.
     */
    private function rules(): array
    {
        return [
            // p205 - hidden field, tetap wajib karena jadi relasi
            'id_p4' => 'required|string|max:100',

            // p206-p208 -> di p4

            // p209
            'lokasi_rt' => 'nullable|string',

            // p210 - satu-satunya field required:true di config
            'topografi' => 'required|in:1,2,3',

            // p211
            'jlm_warga_puncak' => 'nullable|integer|min:0',
            'tanam_pohon_lahan_kritis' => 'nullable|in:1,2,3',

            // p212
            'panjang_garis_pantai' => 'nullable|numeric|min:0',
            // p213
            'perikanan_tangkap' => 'nullable|in:1,2',
            // p214
            'perikanan_budidaya' => 'nullable|in:1,2',
            // p215
            'tambak_garam' => 'nullable|in:1,2',
            // p216
            'wisata_bahari' => 'nullable|in:1,2',
            // p217
            'transportasi_umum' => 'nullable|in:1,2',

            // p218
            'kondisi_mangrove' => 'nullable|in:1,2,3,4,5',
            // p219
            'penanaman_mangrove' => 'nullable|in:1,2,3',
            // p220
            'jlm_warga_pesisir' => 'nullable|integer|min:0',
            // p221
            'jlm_warga_diatas_air' => 'nullable|integer|min:0',

            // p222
            'wilayah_desa_dlm_hutan' => 'nullable|numeric|min:0',
            // p223
            'wilayah_desa_tepi_hutan' => 'nullable|numeric|min:0',

            // p224
            'fungsi_hutan_konservasi' => 'nullable|numeric|min:0',
            'fungsi_hutan_lindung' => 'nullable|numeric|min:0',
            'fungsi_hutan_produksi' => 'nullable|numeric|min:0',
            'fungsi_hutan_desa' => 'nullable|numeric|min:0',

            // p225
            'jlm_warga_dlm_hutan' => 'nullable|integer|min:0',
            // p226
            'jlm_warga_sekitar_hutan' => 'nullable|integer|min:0',
            // p227
            'ketergantungan_hutan' => 'nullable|in:1,2,3,4',
            // p228
            'reboisasi_hutan' => 'nullable|in:1,2,3',
        ];
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

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

        $id = 'RTP2-' . strtotime(now());
        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $data = RtP2M::create(array_merge($validated, [
            'id'         => $id,
            'id_survey'  => $survey->id,
            'id_buat'    => $userId,
            'id_update'  => $userId,
            'tgl_buat'   => now(),
            'tgl_update' => null,
        ]));

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $validated['id_p4'],
            'P2',
            'rt_p2',
            'id_p4',
            [],
            $survey->id
        );

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan',
            'data' => [
                'id' => $data->id,
                'id_survey' => $survey->id,
                'tgl_buat' => $data->tgl_buat,
            ],
        ], 201);
    }

    public function show(string $idP4)
    {
        $survey = \App\Services\SurveyProgressService::getActiveSurvey();
        $query = RtP2M::where('id_p4', $idP4);
        if ($survey) {
            $query->where('id_survey', $survey->id);
        }
        $data = $query->first();
        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditemukan',
            'data' => $data,
        ]);
    }

    public function update(Request $request, string $id)
    {
        $data = RtP2M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan di update tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate($this->rules());

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

        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        $data->update(array_merge($validated, [
            'id_update'  => $userId,
            'tgl_update' => now(),
        ]));

        $idP4 = $validated['id_p4'] ?? $data->id_p4;

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP4,
            'P2',
            'rt_p2',
            'id_p4'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui',
            'data' => $data,
        ]);
    }

    public function destroy(string $idP4)
    {
        $survey = \App\Services\SurveyProgressService::getActiveSurvey();
        $query = RtP2M::where('id_p4', $idP4);
        if ($survey) {
            $query->where('id_survey', $survey->id);
        }
        $deleted = $query->delete();

        if ($deleted === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data yang akan di hapus tidak ditemukan',
            ], 404);
        }

        app(\App\Services\SurveyProgressService::class)->recordDelete($idP4, 'P2', $survey?->id);

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus',
        ]);
    }
}
