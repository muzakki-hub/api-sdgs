<?php

namespace App\Http\Controllers\Api\RT\P11;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\RT\P11\RtP11M;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class P11RtController extends Controller
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

        $data = RtP11M::where('id_p4', $idP4)
            ->where('id_survey', $survey->id)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P11 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P11 ditemukan',
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

            'jumlah_kegiatan_poskamling' => 'required|integer',
            'jumlah_kegiatan_regu_keamanan' => 'required|integer',
            'jumlah_tambahan_hansip' => 'required|integer',

            'pelaporan_tamu' => 'required|in:1,2',
            'inisiatif_siskamling' => 'required|in:1,2',

            'jumlah_anggota_linmas' => 'required|integer',

            'ada_pos_polisi' => 'required|in:1,2',
            'jumlah_pos_polisi_digunakan' => 'nullable|integer',
            'jumlah_pos_polisi_tidak_digunakan' => 'nullable|integer',
            'jarak_ke_pos_polisi_terdekat' => 'nullable|numeric',
            'kemudahan_akses_pos_polisi' => 'required|in:1,2,3',

            'jumlah_korban_bunuh_diri' => 'required|integer',
            'jumlah_lokasi_anak_jalanan' => 'required|integer',
            'jumlah_tempat_gelandangan_pengemis' => 'required|integer',
            'jumlah_lokasi_psk' => 'required|integer',
        ]);

        $id = 'RTP11-' . strtotime(now());
        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        try {
            RtP11M::create(array_merge($validated, [
                'id'         => $id,
                'id_survey'  => $survey->id,
                'id_buat'    => $userId,
                'id_update'  => $userId,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'],
                'P11',
                'rt_p11',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P11 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P11: ' . $e->getMessage(),
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

        $data = RtP11M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required',

            'jumlah_kegiatan_poskamling' => 'required|integer',
            'jumlah_kegiatan_regu_keamanan' => 'required|integer',
            'jumlah_tambahan_hansip' => 'required|integer',

            'pelaporan_tamu' => 'required|in:1,2',
            'inisiatif_siskamling' => 'required|in:1,2',

            'jumlah_anggota_linmas' => 'required|integer',

            'ada_pos_polisi' => 'required|in:1,2',
            'jumlah_pos_polisi_digunakan' => 'nullable|integer',
            'jumlah_pos_polisi_tidak_digunakan' => 'nullable|integer',
            'jarak_ke_pos_polisi_terdekat' => 'nullable|numeric',
            'kemudahan_akses_pos_polisi' => 'required|in:1,2,3',

            'jumlah_korban_bunuh_diri' => 'required|integer',
            'jumlah_lokasi_anak_jalanan' => 'required|integer',
            'jumlah_tempat_gelandangan_pengemis' => 'required|integer',
            'jumlah_lokasi_psk' => 'required|integer',
        ]);

        $userId = Auth::id() ?? $request->user()?->id;
        if (!$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Sesi tidak valid atau pengguna belum login.',
            ], 401);
        }

        try {
            $data->update(array_merge($validated, [
                'id_update'  => $userId,
                'tgl_update' => now(),
            ]));

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $validated['id_p4'] ?? $data->id_p4,
                'P11',
                'rt_p11',
                'id_p4',
                [],
                $survey->id
            );

            return response()->json([
                'status' => true,
                'message' => 'Data RT P11 berhasil diperbarui',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P11: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4)
    {
        $survey = \App\Services\SurveyProgressService::getActiveSurvey();
        $query = RtP11M::where('id_p4', $idP4);
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

        try {
            $data->delete();

            app(\App\Services\SurveyProgressService::class)->recordDelete($idP4, 'P11', $survey?->id);

            return response()->json([
                'status' => true,
                'message' => 'Data RT P11 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P11: ' . $e->getMessage(),
            ], 500);
        }
    }
}
