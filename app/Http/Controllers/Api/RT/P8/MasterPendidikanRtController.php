<?php

namespace App\Http\Controllers\Api\RT\P8;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterPendidikanRTM;

class MasterPendidikanRtController extends Controller
{
    public function index()
    {
        $data = MasterPendidikanRTM::with('transaksi')->orderBy('tgl_buat', 'desc')->get();

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
            'jenjang_pendidikan' => 'required|string',
        ]);

        $id = 'MP-' . strtotime(now());

        try {

            MasterPendidikanRTM::create(array_merge($validated, [
                'id'         => $id,
                'id_buat'    => Auth::id() ?? $request->user()?->id ?? auth('sanctum')->id(),
                'id_update'  => Auth::id() ?? $request->user()?->id ?? auth('sanctum')->id(),
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));


            return response()->json([
                'status' => true,
                'message' => 'Data master jenjang pendidikan berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data master jenjang pendidikan: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function show($id)
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

        $data = MasterPendidikanRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master pendidikan tidak ditemukan',
            ], 404);
        }



        return response()->json([
            'status' => true,
            'message' => 'Data master pendidikan ditemukan.',
            'data' => $data
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $now = Carbon::now();
        $survey = Survey::where('tgl_mulai', '<=', $now)
            ->where('tgl_akhir', '>=', $now)
            ->first();

        $data = MasterPendidikanRTM::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data master pendidikan tidak ditemukan',
            ], 404);
        }

        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun',
            ], 400);
        }

        $validated = $request->validate([
            'jenjang_pendidikan' => 'required|string',
        ]);

        $data->update(array_merge($validated, [
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data master pendidikan berhasil diperbarui',
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


        $master = MasterPendidikanRTM::find($id);

        if ($master->transaksi()->count() > 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data masih digunakan tabel lain'
            ]);
        }

        $master->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data master pendidikan berhasil dihapus.',
        ]);
    }
}
