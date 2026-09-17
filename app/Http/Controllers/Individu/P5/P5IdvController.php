<?php

namespace App\Http\Controllers\Individu\P5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P5\IdvP5M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class P5IdvController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $ididvp1 = session('id_individu_p1');

        if (!$ididvp1) {
            return redirect()->back()->with('error', 'ID Individu P1 tidak ditemukan.');
        }

        $data = IdvP5M::where('id_individu_p1', $ididvp1)->get();
        $datap1 = IdvP1M::where('id', $ididvp1)->first();

        return view('pages.individu.p5.p5idv', compact('data', 'datap1'));
    }

    public function store(Request $request)
    {
        $idP1 = session('id_individu_p1');
        $userId = Auth::user()->id;

        $validated = $request->validate([
            'pendidikan_terakhir' => 'required',
            'bahasa_rumah' => 'required',
            'bahasa_formal' => 'required',
            'kerja_bakti' => 'required|integer',
            'siskampling' => 'required|integer',
            'pesta_rakyat' => 'required|integer',
            'menolong_kematian' => 'required|integer',
            'menolong_sakit' => 'required|integer',
            'menolong_kecelakaan' => 'required|integer',
        ]);

        IdvP5M::create([
            'id' => "IDVP5-" . strtotime(date("Y-m-d H:i:s")),
            'id_individu_p1' => $idP1,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'pendidikan_terakhir_lainnya' => $request->pendidikan_terakhir_lainnya,
            'bahasa_rumah' => $request->bahasa_rumah,
            'bahasa_formal' => $request->bahasa_formal,
            'kerja_bakti' => $request->kerja_bakti,
            'siskampling' => $request->siskampling,
            'pesta_rakyat' => $request->pesta_rakyat,
            'menolong_kematian' => $request->menolong_kematian,
            'menolong_sakit' => $request->menolong_sakit,
            'menolong_kecelakaan' => $request->menolong_kecelakaan,
            'id_buat' => $userId,
            'id_update' => $userId,
            'tgl_buat' => now(),
            'tgl_update' => now(),
        ]);

        return back()->with('success', 'Data berhasil disimpan!');
    }


    public function show(string $id)
    {
        $data = IdvP5M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP5M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 505);
        }

        $data->update(array_merge(
            $request->all(),
            ['id_update' => Auth::user()->id, 'tgl_update' => Carbon::now()]
        ));

        return redirect()->back()->with('success', 'Data Individu P5 berhasil diperbarui');
    }

    public function destroy($id)
    {
        IdvP5M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Individu P5 berhasil dihapus.');
    }
}
