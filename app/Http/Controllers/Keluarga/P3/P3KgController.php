<?php

namespace App\Http\Controllers\Keluarga\P3;

use App\Http\Controllers\Controller;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Http\Request;
use App\Models\Keluarga\P3\KgP3M;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P3KgController extends Controller
{
    public function index()
    {
        // dd(session()->all());

        $idKgP2 = session('id_kg_p2');

        if (!$idKgP2) {
            return redirect()->back()->with('error', 'ID Keluarga tidak ditemukan.');
        }

        $data = KgP3M::where('id_kg_p2', $idKgP2)->get();
        $datap2 = KgP2M::where('id', $idKgP2)->first();

        return view('pages.keluarga.p3.kgp3', compact('data', 'datap2'));
    }


    public function store(Request $request)
    {
        $idKgP2 = session('id_kg_p2');
        $userId = Auth::user()->id;
        $request->validate([
            'no_kk' => 'required|string',
            'nik_kk' => 'required|string',
        ]);

        try {
            $keluarga = KgP3M::create([
                'id' => "KGP3-" . strtotime(date("Y-m-d H:i:s")),
                'id_buat' => $userId,
                'tgl_buat' => now(),
                'tgl_update' => now(),

                // Data dari form
                'id_kg_p2' => $idKgP2,
                'no_kk' => $request->no_kk,
                'nik_kk' => $request->nik_kk,
            ]);

            return redirect()->back()->with('success', 'Data keluarga berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p5: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = KgP3M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = KgP3M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->update(array_merge(
            $request->all(),
            ['id_update' => Auth::user()->id, 'tgl_update' => Carbon::now()]
        ));

        return redirect()->back()->with('success', 'Data keluarga berhasil diperbarui');

    }

    public function destroy($id)
    {
        KgP3M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data keluarga P3 berhasil dihapus.');
    }
}
