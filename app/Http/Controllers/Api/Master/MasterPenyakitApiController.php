<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\MasterPenyakitM;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MasterPenyakitApiController extends Controller
{
     public function index()
    {
        $data = MasterPenyakitM::orderBy('jenis_penyakit')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data master penyakit berhasil dimuat',
            'data' => $data
        ]);
    }

    /**
     * Tambah master penyakit baru
     */
    public function store(Request $request)
    {
        $today = Carbon::now();

        $request->validate([
            'jenis_penyakit' => 'required|string',
        ]);

        $data = MasterPenyakitM::create([
            'id' => "MST-PNYKT-" . strtotime(date("Y-m-d H:i:s")),
            'jenis_penyakit' => $request->jenis_penyakit,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Master penyakit berhasil ditambahkan',
            'data' => $data
        ]);
    }

    /**
     * Tampilkan satu data master penyakit
     */
    public function show($id)
    {
        $data = MasterPenyakitM::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data master penyakit berhasil dimuat',
            'data' => $data
        ]);
    }

    /**
     * Update master penyakit
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_penyakit' => 'required|string',
        ]);

        $data = MasterPenyakitM::where('id', $id)->update([
            'jenis_penyakit' => $request->jenis_penyakit,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Master penyakit berhasil diperbarui',
            'data' => $data
        ]);
    }

    /**
     * Hapus master penyakit
     */
    public function destroy($id)
    {
        MasterPenyakitM::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Master penyakit berhasil dihapus'
        ]);
    }
}
