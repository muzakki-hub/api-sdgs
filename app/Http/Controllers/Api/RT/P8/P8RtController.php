<?php

namespace App\Http\Controllers\Api\RT\P8;

use Carbon\Carbon;
use App\Models\RT\P8\RtP8M;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;

class P8RtController extends Controller
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


        $data = RtP8M::where('id_p4', $idP4)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P8 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P8 ditemukan',
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

            'perpustakaan_taman_bacaan'=> 'required|in:1,2',
        ]);

        $id = 'RTP8-' . strtotime(now());

        try {
            RtP8M::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P8 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P8: ' . $e->getMessage(),
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

        $data = RtP8M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

         $validated = $request->validate([
            'id_p4' => 'required|string|max:25',

            'perpustakaan_taman_bacaan'=> 'required|in:1,2',
        ]);
         try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P8 berhasil diperbarui',
                'data' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P8: ' . $e->getMessage(),
            ], 500);
        }
    }

       public function destroy($idP4)
    {
        $data = RtP8M::where('id_p4', $idP4)->first();

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
                'message' => 'Data RT P8 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P8: ' . $e->getMessage(),
            ], 500);
        }
    }
}
