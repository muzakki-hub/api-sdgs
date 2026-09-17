<?php

namespace App\Http\Controllers\Api\RT\P9;

use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use App\Models\RT\P9\TransaksiKlbP9RTM;

class TransaksiKlbP9RtController extends Controller
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
            'id_master_klb' => 'required|string|max:25',
            'kejadian'       => 'required|in:1,2',
            'jml_penderita'  => 'nullable|integer',
            'jml_meninggal'  => 'nullable|integer',
        ]);

        $id = 'P902-' . strtotime(now());

        try {
            TransaksiKlbP9RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P902 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($idP4, $idMasterKlb)
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

        $data = TransaksiKlbP9RTM::where('id_p4', $idP4)
            ->where('id_master_klb', $idMasterKlb)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data ditemukan',
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
        $data = TransaksiKlbP9RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_p4' => 'required|string|max:25',
            'id_master_klb' => 'required|string|max:25',
            'kejadian'       => 'required|in:1,2',
            'jml_penderita'  => 'nullable|integer',
            'jml_meninggal'  => 'nullable|integer',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P902 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroy($idP4, $idMasterKlb)
    {
        $data = TransaksiKlbP9RTM::where('id_p4', $idP4)->where('id_master_klb', $idMasterKlb)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P902 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P902 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P902: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $deleted = TransaksiKlbP9RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P902 berhasil dihapus',
        ], 200);
    }
}
