<?php

namespace App\Http\Controllers\Api\RT\P10;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RT\P10\RtP10M;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;

class P10RtController extends Controller
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

        $data = RtP10M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P10 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P10 ditemukan',
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

            'peserta_jamkes' => 'required|integer',
            'peserta_jamkerja' => 'required|integer',

            'jml_masjid' => 'required|integer',
            'jml_musala' => 'required|integer',
            'jml_gereja_kristen' => 'required|integer',
            'jml_gereja_katolik' => 'required|integer',
            'jml_kapel' => 'required|integer',
            'jml_pura' => 'required|integer',
            'jml_wihara' => 'required|integer',
            'jml_kelenteng' => 'required|integer',
            'jml_lain_tempat_ibadah' => 'required|integer',

            'cagar_budaya' => 'nullable|string',

            'jml_keluarga_suku_terasing' => 'required|integer',
            'jml_jiwa_suku_terasing' => 'required|integer',

            'ruang_publik_terbuka' => 'required|in:1,2,3',

            'kearifan_kehamilan' => 'nullable|string',
            'kearifan_kelahiran' => 'nullable|string',
            'kearifan_pekerjaan' => 'nullable|string',
            'kearifan_alam' => 'nullable|string',
            'kearifan_perkawinan' => 'nullable|string',
            'kearifan_kehidupan' => 'nullable|string',
            'kearifan_kematian' => 'nullable|string',
        ]);

        $id = 'RTP10-' . strtotime(now());

        try {
            RtP10M::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P10 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P10: ' . $e->getMessage(),
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

        $data = RtP10M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required',

            'peserta_jamkes' => 'required|integer',
            'peserta_jamkerja' => 'required|integer',

            'jml_masjid' => 'required|integer',
            'jml_musala' => 'required|integer',
            'jml_gereja_kristen' => 'required|integer',
            'jml_gereja_katolik' => 'required|integer',
            'jml_kapel' => 'required|integer',
            'jml_pura' => 'required|integer',
            'jml_wihara' => 'required|integer',
            'jml_kelenteng' => 'required|integer',
            'jml_lain_tempat_ibadah' => 'required|integer',

            'cagar_budaya' => 'nullable|string',

            'jml_keluarga_suku_terasing' => 'required|integer',
            'jml_jiwa_suku_terasing' => 'required|integer',

            'ruang_publik_terbuka' => 'required|in:1,2,3',

            'kearifan_kehamilan' => 'nullable|string',
            'kearifan_kelahiran' => 'nullable|string',
            'kearifan_pekerjaan' => 'nullable|string',
            'kearifan_alam' => 'nullable|string',
            'kearifan_perkawinan' => 'nullable|string',
            'kearifan_kehidupan' => 'nullable|string',
            'kearifan_kematian' => 'nullable|string',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P10 berhasil diperbarui',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P10: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4)
    {
        $data = RtP10M::where('id_p4', $idP4)->first();

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
                'message' => 'Data RT P10 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P10: ' . $e->getMessage(),
            ], 500);
        }
    }
}
