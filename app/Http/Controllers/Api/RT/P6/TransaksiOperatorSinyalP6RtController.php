<?php

namespace App\Http\Controllers\Api\RT\P6;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\RT\P6\TransaksiOperatorSinyalP6RTM;

class TransaksiOperatorSinyalP6RtController extends Controller
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
            'id_master_operator_sinyal' => 'required|string|max:25',
            'jenis_sinyal_1'            => 'required|in:1,2,3,4',
            'jenis_sinyal_2' => 'required|in:1,2,3,4',
        ]);

        $id = 'P607-' . strtotime(now());

        try {
            TransaksiOperatorSinyalP6RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P607 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function show($idP4, $idMasterOperatorSinyal)
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

        $data = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)
            ->where('id_master_operator_sinyal', $idMasterOperatorSinyal)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
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
        $data = TransaksiOperatorSinyalP6RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
           'id_p4' => 'required|string|max:25',
            'id_master_operator_sinyal' => 'required|string|max:25',
            'jenis_sinyal_1'            => 'required|in:1,2,3,4',
            'jenis_sinyal_2' => 'required|in:1,2,3,4',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P607 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function destroy($idP4, $idMasterOperatorSinyal)
    {
        $data = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)->where('id_master_operator_sinyal', $idMasterOperatorSinyal)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P607 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P607 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P607: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $deleted = TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan ' .$idP4,
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P607 berhasil dihapus',
        ], 200);
    }
}
