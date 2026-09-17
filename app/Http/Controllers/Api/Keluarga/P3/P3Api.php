<?php

namespace App\Http\Controllers\Api\Keluarga\P3;

use App\Http\Controllers\Controller;
use App\Models\Keluarga\P3\KgP3M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P3Api extends Controller
{
    public function index()
    {
        $data = KgP3M::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        $today = Carbon::now();
        $data = KgP3M::create([
            'id' => "KG-" . strtotime(date("Y-m-d H:i:s")),
            'id_kg_p2' => $request->id_kg_p2,
            'no_kk' => $request->no_kk,
            'nik_kk' => $request->nik_kk,

            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil disimpan',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = KgP3M::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil di Tampilkan',
            'data' => $data
        ]);
    }
    public function showByIdP2($id)
    {
        $data = KgP3M::where('id_kg_p2', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berdasarkan ID P2',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now();
        $data = KgP3M::where('id', $id)->update([
            'no_kk' => $request->no_kk,
            'nik_kk' => $request->nik_kk,

            // 'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            // 'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data P3 keluarga berhasil di update',
            'data' => $data
        ]);
    }
    public function destroy($id)
    {
        KgP3M::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Data P3 Berhasil Dihapus"
        ]);
    }
}
