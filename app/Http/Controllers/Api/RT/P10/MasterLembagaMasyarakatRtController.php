<?php

namespace App\Http\Controllers\Api\RT\P10;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterLembagaMasyarakatRTM;

class MasterLembagaMasyarakatRtController extends Controller
{
     public function index()
    {
        $data = MasterLembagaMasyarakatRTM::with('transaksi')->orderBy('tgl_buat', 'desc')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Belum ada data yang tersimpan',
            ]);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diambil',
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
            'nama_lembaga' => 'required|string|max:150',
        ]);

        $id = 'MLK-' . strtotime(now());

        try {

            MasterLembagaMasyarakatRTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));


            return response()->json([
                'status' => true,
                'message' => 'Data master lembaga kemasyarakatan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data master lembaga kemasyarakatan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = MasterLembagaMasyarakatRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master lembaga kemasyarakatan tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data master lembaga kemasyarakatan ditemukan.',
            'data' => $data
        ], 200);
    }

     public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = MasterLembagaMasyarakatRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master lembaga kemasyarakatan tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $validated = $request->validate([
            'nama_lembaga' => 'required|string|max:150',
        ]);

        $data->update(array_merge($validated, [
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data master lembaga kemasyarakatan berhasil diperbarui',
            'data' => $data
        ], 200);
    }

    public function destroy($id)
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


        $master = MasterLembagaMasyarakatRTM::find($id);

        if ($master->transaksi()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data masih digunakan tabel lain'
            ]);
        }

        $master->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data master lembaga kemasyarakatan berhasil dihapus.',
        ]);
    }
}
