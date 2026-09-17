<?php

namespace App\Http\Controllers\Api\Individu\P2;

use App\Http\Controllers\Controller;
use App\Models\Individu\P2\IdvP2M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P2IdvApi extends Controller
{
    public function index()
    {
        $data = IdvP2M::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        $today = Carbon::now();

        // $validated = $request->validate([
        //     'kondisi_pekerjaan' => 'required',
        //     'pekerjaan_utama' => 'required',
        //     'jsk' => 'required',
        // ]);

        $data = IdvP2M::create([
            'id' => "IDVP2-" . strtotime(date("Y-m-d H:i:s")),
            'id_individu_p1' => $request->id_individu_p1,
            'kondisi_pekerjaan' => $request->kondisi_pekerjaan,
            'pekerjaan_utama' => $request->pekerjaan_utama,
            'pekerjaan_lainnya' => $request->pekerjaan_lainnya,
            'jsk' => $request->jsk,

            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P2 berhasil disimpan',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = IdvP2M::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P2 berhasil di Tampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now();
        $data = IdvP2M::where('id', $id)->update([
            'kondisi_pekerjaan' => $request->kondisi_pekerjaan,
            'pekerjaan_utama' => $request->pekerjaan_utama,
            'pekerjaan_lainnya' => $request->pekerjaan_lainnya,
            'jsk' => $request->jsk,

            // 'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            // 'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P2 berhasil di update',
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        IdvP2M::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Data Individu P2 Berhasil Dihapus"
        ]);
    }

    public function showByIdP1($id)
    {
        $data = IdvP2M::where('id_individu_p1', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data Individu berdasarkan ID P1',
            'data' => $data
        ]);
    }
}
