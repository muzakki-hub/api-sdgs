<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use App\Models\RT\P7\RtP7M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;

class P7RtController extends Controller
{
    public function show($idP4)
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


        $data = RtP7M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P7 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P7 ditemukan',
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
        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',
            'lhn_sawah_irigasi' => 'nullable|numeric',
            'lhn_sawah_nonirigasi' => 'nullable|numeric',
            'lhn_kebun' => 'nullable|numeric',
            'lhn_huma' => 'nullable|numeric',
            'lhn_tambak' => 'nullable|numeric',
            'lhn_kolam' => 'nullable|numeric',
            'lhn_gembala' => 'nullable|numeric',
            'lhn_perkebunan' => 'nullable|numeric',
            'lhn_hutan' => 'nullable|numeric',
            'lhn_non_sawah' => 'nullable|numeric',
            'lhn_tambang' => 'nullable|numeric',
            'lhn_perumahan' => 'nullable|numeric',
            'lhn_perkantoran' => 'nullable|numeric',
            'lhn_pertokoan' => 'nullable|numeric',
            'lhn_industri' => 'nullable|numeric',
            'lhn_fasum' => 'nullable|numeric',
            'lhn_lain' => 'nullable|numeric',
            'nama_sungai' => 'nullable',
            'nama_danau' => 'nullable',
            'jml_mata_air' => 'nullable|integer',
            'jml_embung' => 'nullable|integer',
            'limbah_industri' => 'required|in:1,2',
            'limbah_rumah_tangga' => 'required|in:1,2',
            'limbah_lain' => 'required|in:1,2',
            'lokasi_limbah' => 'required|in:1,2,3,4',
            'daur_ulang_sampah' => 'required|in:1,2,3',
            'bakar_ladang' => 'required|in:1,2',
            'lokasi_penggalian_c' => 'required|in:1,2',
            'sistem_peringatan_dini' => 'required|in:1,2',
            'sistem_tsunami' => 'required|in:1,2,3',
            'perlengkapan_keselamatan' => 'required|in:1,2',
            'rambu_jalur_evakuasi' => 'required|in:1,2',
            'normalisasi_sumber_air' => 'required|in:1,2',
        ]);

        $id = 'RTP7-' . strtotime(now());

        try {
            RtP7M::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P7 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P7: ' . $e->getMessage(),
            ], 500);
        }
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

        $data = RtP7M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required',
            'lhn_sawah_irigasi' => 'nullable|numeric',
            'lhn_sawah_nonirigasi' => 'nullable|numeric',
            'lhn_kebun' => 'nullable|numeric',
            'lhn_huma' => 'nullable|numeric',
            'lhn_tambak' => 'nullable|numeric',
            'lhn_kolam' => 'nullable|numeric',
            'lhn_gembala' => 'nullable|numeric',
            'lhn_perkebunan' => 'nullable|numeric',
            'lhn_hutan' => 'nullable|numeric',
            'lhn_non_sawah' => 'nullable|numeric',
            'lhn_tambang' => 'nullable|numeric',
            'lhn_perumahan' => 'nullable|numeric',
            'lhn_perkantoran' => 'nullable|numeric',
            'lhn_pertokoan' => 'nullable|numeric',
            'lhn_industri' => 'nullable|numeric',
            'lhn_fasum' => 'nullable|numeric',
            'lhn_lain' => 'nullable|numeric',
            'nama_sungai' => 'nullable',
            'nama_danau' => 'nullable',
            'jml_mata_air' => 'nullable|integer',
            'jml_embung' => 'nullable|integer',
            'limbah_industri' => 'required|in:1,2',
            'limbah_rumah_tangga' => 'required|in:1,2',
            'limbah_lain' => 'required|in:1,2',
            'lokasi_limbah' => 'required|in:1,2,3,4',
            'daur_ulang_sampah' => 'required|in:1,2,3',
            'bakar_ladang' => 'required|in:1,2',
            'lokasi_penggalian_c' => 'required|in:1,2',
            'sistem_peringatan_dini' => 'required|in:1,2',
            'sistem_tsunami' => 'required|in:1,2,3',
            'perlengkapan_keselamatan' => 'required|in:1,2',
            'rambu_jalur_evakuasi' => 'required|in:1,2',
            'normalisasi_sumber_air' => 'required|in:1,2',
        ]);


        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P7 berhasil diperbarui',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P7: ' . $e->getMessage(),
            ], 500);
        }
    }

        public function destroy($idP4)
    {
        $data = RtP7M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P7 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P7: ' . $e->getMessage(),
            ], 500);
        }
    }
}
