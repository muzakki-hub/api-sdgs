<?php

namespace App\Http\Controllers\Individu\P2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P2\IdvP2M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class P2IdvController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $ididvp1 = session('id_individu_p1');

        if (!$ididvp1) {
            return redirect()->back()->with('error', 'ID Individu P1 tidak ditemukan.');
        }

        $data = IdvP2M::where('id_individu_p1', $ididvp1)->get();
        $datap1 = IdvP1M::where('id', $ididvp1)->first();

        return view('pages.individu.p2.p2idv', compact('data', 'datap1'));
    }

    public function store(Request $request)
    {
        $idKgP1 = session('id_individu_p1');
        $userId = Auth::user()->id;
       
        $validated = $request->validate([
            // 'id_individu_p1' => 'required',
            'kondisi_pekerjaan' => 'required',
            'pekerjaan_utama' => 'required',
            'jsk' => 'required',
        ]);

        try {

            $p1 = IdvP2M::create([
                'id' => "IDVP2-" . strtotime(date("Y-m-d H:i:s")),
                'id_individu_p1' => $idKgP1,
                'kondisi_pekerjaan' => $validated['kondisi_pekerjaan'],
                'pekerjaan_utama' => $validated['pekerjaan_utama'],
                'pekerjaan_lainnya' => $request->pekerjaan_lainnya,
                'jsk' => $validated['jsk'],
                'id_buat' => $userId,
                // 'id_update' => auth()->user()->id ?? 'system',
                'tgl_buat' => now(),
                'tgl_update' => now(),
            ]);

            return redirect()->route('idv-p2.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $e) {

            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p2: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = IdvP2M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP2M::find($id);

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

        return redirect()->back()->with('success', 'Data Individu P2 berhasil diperbarui');
    }

    public function destroy($id)
    {
        IdvP2M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Individu P2 berhasil dihapus.');
    }
}
