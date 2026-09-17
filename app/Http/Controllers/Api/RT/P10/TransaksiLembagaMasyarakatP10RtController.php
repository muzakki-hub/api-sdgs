<?php

namespace App\Http\Controllers\Api\RT\P10;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P10\TransaksiLembagaMasyarakatP10RTM;

class TransaksiLembagaMasyarakatP10RtController extends Controller
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
            'id_master_lembaga_masyarakat' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'jumlah_kelompok' => 'required|integer|min:0',
            'jumlah_pengurus' => 'required|integer|min:0',
            'jumlah_anggota' => 'required|integer|min:0',

            'fasilitas' => 'required|in:1,2,3,4',
        ]);

        $id = 'P1009-' . strtotime(now());

        try {
            TransaksiLembagaMasyarakatP10RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P1009 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P1009: ' . $e->getMessage(),
            ], 500);
        }
    }
    public function show($idP4, $idMasterLembaga)
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

        $data = TransaksiLembagaMasyarakatP10RTM::where('id_p4', $idP4)
            ->where('id_master_lembaga_masyarakat', $idMasterLembaga)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1009 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P1009 ditemukan',
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

        $data = TransaksiLembagaMasyarakatP10RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1009 tidak ditemukan',
            ], 404);
        }

        // VALIDASI
        $validated = $request->validate([
            'id_master_lembaga_masyarakat' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'jumlah_kelompok' => 'required|integer|min:0',
            'jumlah_pengurus' => 'required|integer|min:0',
            'jumlah_anggota' => 'required|integer|min:0',

            'fasilitas' => 'required|in:1,2,3,4',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P1009 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P1009: ' . $e->getMessage(),
            ], 500);
        }
    }



    public function destroy($idP4, $idMasterLembaga)
    {
        $data = TransaksiLembagaMasyarakatP10RTM::where('id_p4', $idP4)
            ->where('id_master_lembaga_masyarakat', $idMasterLembaga)
            ->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P1009 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P1009 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P1009: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $deleted = TransaksiLembagaMasyarakatP10RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P1009 berhasil dihapus',
        ], 200);
    }
}
