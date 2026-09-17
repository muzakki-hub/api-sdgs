<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\MasterSarkesM;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MasterSarkesApiController extends Controller
{
     public function index()
    {
        $data = MasterSarkesM::orderBy('nama_sarkes')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data master sarkes berhasil dimuat',
            'data' => $data
        ]);
    }

    /**
     * Tambah master sarkes baru
     */
    public function store(Request $request)
    {
        $today = Carbon::now();

        $request->validate([
            'nama_sarkes' => 'required|string',
        ]);

        $data = MastersarkesM::create([
            'id' => "MST-PNYKT-" . strtotime(date("Y-m-d H:i:s")),
            'nama_sarkes' => $request->nama_sarkes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Master sarkes berhasil ditambahkan',
            'data' => $data
        ]);
    }

    /**
     * Tampilkan satu data master sarkes
     */
    public function show($id)
    {
        $data = MasterSarkesM::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data master sarkes berhasil dimuat',
            'data' => $data
        ]);
    }

    /**
     * Update master sarkes
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_sarkes' => 'required|string',
        ]);

        $data = MasterSarkesM::where('id', $id)->update([
            'nama_sarkes' => $request->nama_sarkes,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Master sarkes berhasil diperbarui',
            'data' => $data
        ]);
    }

    /**
     * Hapus master sarkes
     */
    public function destroy($id)
    {
        MasterSarkesM::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => 'Master sarkes berhasil dihapus'
        ]);
    }
}
