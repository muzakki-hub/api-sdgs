<?php

namespace App\Http\Controllers\Api\RT\P5;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P5\TransaksiSaranaEkonomiP5RTM;

class TransaksiSaranaEkonomiP5RtController extends Controller
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
            'id_master_sarana_ekonomi' => 'required|string|max:25',
            'jumlah' => 'required|integer',
            'kondisi' => 'required|in:1,2,3,4',
            'jarak_sarana' => 'nullable|numeric',
            'kemudahan_mencapai' => 'required|in:1,2,3,4',
        ]);

        $id = 'P508-' . strtotime(now());

        try {
            TransaksiSaranaEkonomiP5RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P508 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P508: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterSaranaEkonomi)
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

        $data = TransaksiSaranaEkonomiP5RTM::where('id_p4', $idP4)
            ->where('id_master_sarana_ekonomi', $idMasterSaranaEkonomi)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P508 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P508 ditemukan',
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
        $data = TransaksiSaranaEkonomiP5RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P508 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_master_sarana_ekonomi' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',
            'jumlah' => 'required|integer',
            'kondisi' => 'required|in:1,2,3,4',
            'jarak_sarana' => 'nullable|numeric',
            'kemudahan_mencapai' => 'required|in:1,2,3,4',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P508 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P508: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterSaranaEkonomi)
    {
        $data = TransaksiSaranaEkonomiP5RTM::where('id_p4', $idP4)->where('id_master_sarana_ekonomi', $idMasterSaranaEkonomi)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P508 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P508 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P508: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function destroyAll($idP4)
    {
        $deleted = TransaksiSaranaEkonomiP5RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P508 berhasil dihapus',
        ], 200);
    }
}
