<?php

namespace App\Http\Controllers\Api\RT\P6;

use Carbon\Carbon;
use App\Models\RT\P6\RtP6M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class P6RtController extends Controller
{
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
            'penerangan_jalan' => 'required|in:1,2,3,4',
            'prasarana_transport_antar_rt' => 'required|in:1,2,3,4',
            'pj_jalan_aspal' => 'nullable|numeric',
            'pj_jalan_kerikil' => 'nullable|numeric',
            'pj_jalan_tanah' => 'nullable|numeric',
            'pj_jalan_papan' => 'nullable|numeric',
            'pj_jalan_setapak' => 'nullable|numeric',
            'pj_jalan_lain' => 'nullable|numeric',
            'akses_jalan_roda_4' => 'required|in:1,2,3,4',
            'angkutan_trayek' => 'required|in:1,2,3',
            'angkutan_operasional' => 'required|in:1,2',
            'angkutan_jam_operasional' => 'required|in:1,2',
            'dermaga' => 'required|in:1,2,3,4',
            'jml_bts' => 'nullable|integer',
            'kantor_pos' => 'required|in:1,2,3,4',
            'pos_keliling' => 'required|in:1,2',
            'ekspedisi_swasta' => 'required|in:1,2,3,4',
            'jml_permukiman_liar' => 'nullable|integer',
            'fasum_pasar' => 'nullable|integer',
            'fasum_stasiun' => 'nullable|integer',
            'fasum_terminal' => 'nullable|integer',
            'fasum_jembatan' => 'nullable|integer',
            'fasum_pelabuhan' => 'nullable|integer',
            'jml_rumah_mewah' => 'nullable|integer',
            'jml_apartemen' => 'nullable|integer',
            'jml_rusun' => 'nullable|integer',
            'jml_boarding_school' => 'nullable|integer',
            'jml_kos' => 'nullable|integer',
            'jml_asrama_militer' => 'nullable|integer',
            'jml_lapas' => 'nullable|integer',
        ]);

        $id = 'RTP6-' . strtotime(now());
        $userId = Auth::id() ?? $request->user()?->id ?? '1750899536';

        try {
            RtP6M::create(array_merge($validated, [
                'id'         => $id,
                'id_buat'    => $userId,
                'id_update'  => $userId,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P6 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P6: ' . $e->getMessage(),
            ], 500);
        }
    }

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

        $data = RtP6M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P6 ditemukan.',
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

        $data = RtP6M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required|string|max:100',
            'penerangan_jalan' => 'required|in:1,2,3,4',
            'prasarana_transport_antar_rt' => 'required|in:1,2,3,4',
            'pj_jalan_aspal' => 'nullable|numeric',
            'pj_jalan_kerikil' => 'nullable|numeric',
            'pj_jalan_tanah' => 'nullable|numeric',
            'pj_jalan_papan' => 'nullable|numeric',
            'pj_jalan_setapak' => 'nullable|numeric',
            'pj_jalan_lain' => 'nullable|numeric',
            'akses_jalan_roda_4' => 'required|in:1,2,3,4',
            'angkutan_trayek' => 'required|in:1,2,3',
            'angkutan_operasional' => 'required|in:1,2',
            'angkutan_jam_operasional' => 'required|in:1,2',
            'dermaga' => 'required|in:1,2,3,4',
            'jml_bts' => 'nullable|integer',
            'kantor_pos' => 'required|in:1,2,3,4',
            'pos_keliling' => 'required|in:1,2',
            'ekspedisi_swasta' => 'required|in:1,2,3,4',
            'jml_permukiman_liar' => 'nullable|integer',
            'fasum_pasar' => 'nullable|integer',
            'fasum_stasiun' => 'nullable|integer',
            'fasum_terminal' => 'nullable|integer',
            'fasum_jembatan' => 'nullable|integer',
            'fasum_pelabuhan' => 'nullable|integer',
            'jml_rumah_mewah' => 'nullable|integer',
            'jml_apartemen' => 'nullable|integer',
            'jml_rusun' => 'nullable|integer',
            'jml_boarding_school' => 'nullable|integer',
            'jml_kos' => 'nullable|integer',
            'jml_asrama_militer' => 'nullable|integer',
            'jml_lapas' => 'nullable|integer',
        ]);

        $userId = Auth::id() ?? $request->user()?->id ?? '1750899536';

        try {
            $data->update(array_merge($validated, [
                'id_update'  => $userId,
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P6 berhasil diperbarui',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P6: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4)
    {
        $data = RtP6M::where('id_p4', $idP4)->first();

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
                'message' => 'Data RT P6 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P6: ' . $e->getMessage(),
            ], 500);
        }
    }
}
