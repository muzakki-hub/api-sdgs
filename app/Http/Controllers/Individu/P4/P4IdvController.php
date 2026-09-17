<?php

namespace App\Http\Controllers\Individu\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P4\IdvP4M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class P4IdvController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $ididvp1 = session('id_individu_p1');

        if (!$ididvp1) {
            return redirect()->back()->with('error', 'ID Individu P1 tidak ditemukan.');
        }

        $data = IdvP4M::where('id_individu_p1', $ididvp1)->get();
        $datap1 = IdvP1M::where('id', $ididvp1)->first();

        return view('pages.individu.p4.p4idv', compact('data', 'datap1'));
    }

    public function store(Request $request)
    {
        $idKgP1 = session('id_individu_p1');
        $userId = Auth::user()->id;
        try {

            $p1 = IdvP4M::create([
                'id' => "IDVP4-" . strtotime(date("Y-m-d H:i:s")),
                'id_individu_p1' => $idKgP1,
                'tunanetra' => $request->tunanetra,
                'tunarungu' => $request->tunarungu,
                'tunawicara' => $request->tunawicara,
                'tunadaksa' => $request->tunadaksa,
                'tunagrahita' => $request->tunagrahita,
                'tunalaras' => $request->tunalaras,
                'cacat_eks_sakitkusta' => $request->cacat_eks_sakitkusta,
                'cacat_ganda' => $request->cacat_ganda,
                'dipasung' => $request->dipasung,

                'id_buat' => $userId,
                'id_update' => '',
                'tgl_buat' => now(),
                'tgl_update' => now(),
            ]);

            return redirect()->route('idv-p4.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $e) {

            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p4: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = IdvP4M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP4M::find($id);

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

        return redirect()->back()->with('success', 'Data Individu P4 berhasil diperbarui');
    }

    public function destroy($id)
    {
        IdvP4M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Individu P4 berhasil dihapus.');
    }
}
