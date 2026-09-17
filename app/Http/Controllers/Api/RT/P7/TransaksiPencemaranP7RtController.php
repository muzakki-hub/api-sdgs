<?php

namespace App\Http\Controllers\Api\RT\P7;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P7\TransaksiPencemaranP7RTM;

class TransaksiPencemaranP7RtController extends Controller
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

        $id = 'P709-' . strtotime(now());

        try {
            TransaksiPencemaranP7RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P709 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P709: ' . $e->getMessage(),
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
            ->where('id_master_lingkungan', $idMasterLingkungan)->first();

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
        $data = TransaksiPencemaranP7RTM::where('id_p4', $idP4)->where('id_master_lingkungan', $idMasterLingkungan)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P709 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

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
        $deleted = TransaksiPencemaranP7RTM::where('id_p4', $idP4)->delete();

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
