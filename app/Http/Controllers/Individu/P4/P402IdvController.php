<?php

namespace App\Http\Controllers\Individu\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P4\IdvP402M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Master\MasterSarkesM;

class P402IdvController extends Controller
{
    public function index()
    {
        $ididvp1 = session('id_individu_p1');

        if (!$ididvp1) {
            return redirect()->back()->with('error', 'ID Individu P1 tidak ditemukan.');
        }
        $data = IdvP402M::with('masterSarkes')
            ->where('id_individu_p1', $ididvp1)
            ->get();

        $datap1 = IdvP1M::where('id', $ididvp1)->first();
        $masterSarkes = MasterSarkesM::all();


        return view('pages.individu.p4.p402idv', compact('data', 'datap1', 'masterSarkes'));
    }

    public function store(Request $request)
    {
        $idKgP1 = session('id_individu_p1');
        $userId = Auth::user()->id;

        $validated = $request->validate([
            'id_master_sarkes' => 'required',
        ]);

        try {

            $p1 = IdvP402M::create([
                'id' => "IDVP402-" . strtotime(date("Y-m-d H:i:s")),
                'id_individu_p1' => $idKgP1,
                'id_master_sarkes' => $validated['id_master_sarkes'],
                'jml_berkunjung' => $request->jml_berkunjung,
                'id_buat' => $userId,
                'id_update' => '',
                'tgl_buat' => now(),
                'tgl_update' => now(),
            ]);

            return redirect()->route('idv-p402.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $e) {

            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p4: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = IdvP402M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP402M::find($id);

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

        return redirect()->back()->with('success', 'Data Individu P402 berhasil diperbarui');
    }

    public function destroy($id)
    {
        IdvP402M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Individu P402 berhasil dihapus.');
    }
}
