<?php

namespace App\Http\Controllers\Api\RT\P9;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterKesehatanRTM;
use App\Models\RT\P9\TransaksiKesehatanP9RTM;

class TransaksiKesehatanP9RtController extends Controller
{
    public function index($idP4)
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

        $data = TransaksiKesehatanP9RTM::with('masterKesehatan')->where('id_p4', $idP4)->orderBy('tgl_buat', 'desc')->get();

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
            'id_master_kesehatan' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'nama_sarana' => 'required|string',
            'pemilik' => 'required|in:1,2',

            'jml_dokter' => 'required|integer|min:0',
            'jml_bidan' => 'required|integer|min:0',
            'jml_tenaga_kesehatan' => 'required|integer|min:0',
            'jml_pegawai_lain' => 'required|integer|min:0',
        ]);

        $id = 'P901-' . strtotime(now());

        try {
            TransaksiKesehatanP9RTM::create(array_merge($validated, [
                'id'         => $id,
                'tgl_buat'   => now(),
                'tgl_update' => null,
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil disimpan',
                'id' => $id,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data RT P901: ' . $e->getMessage(),
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

        $data = TransaksiKesehatanP9RTM::find($id);
        $dataMaster = MasterKesehatanRTM::orderBy('tgl_buat', 'desc')->get();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P901 ditemukan',
            'data' => [
                'data' => $data,
                'dataMaster' => $dataMaster
            ],
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
        $data = TransaksiKesehatanP9RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        $validated = $request->validate([
            'id_master_kesehatan' => 'required|string|max:25',
            'id_p4' => 'required|string|max:25',

            'nama_sarana' => 'required|string',
            'pemilik' => 'required|in:1,2',

            'jml_dokter' => 'required|integer|min:0',
            'jml_bidan' => 'required|integer|min:0',
            'jml_tenaga_kesehatan' => 'required|integer|min:0',
            'jml_pegawai_lain' => 'required|integer|min:0',
        ]);

        try {
            $data->update(array_merge($validated, [
                'tgl_update' => now(),
            ]));

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil diperbarui',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data RT P901: ' . $e->getMessage(),
            ], 500);
        }
    }

     public function destroy($id)
    {
        $data = TransaksiKesehatanP9RTM::where('id', $id)->first();

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT P901 tidak ditemukan',
            ], 404);
        }

        try {
            $data->delete();

            return response()->json([
                'status' => true,
                'message' => 'Data RT P901 berhasil dihapus',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data RT P901: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function destroyAll($idP4)
    {
        $deleted = TransaksiKesehatanP9RTM::where('id_p4', $idP4)->delete();

        if ($deleted == 0) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data RT P901 berhasil dihapus',
        ], 200);
    }
}
