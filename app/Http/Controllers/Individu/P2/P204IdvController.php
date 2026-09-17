<?php

namespace App\Http\Controllers\Individu\P2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P2\IdvP204M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use App\Models\Master\MasterPenghasilanM;

class P204IdvController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $ididvp1 = session('id_individu_p1');

        if (!$ididvp1) {
            return redirect()->back()->with('error', 'ID Individu P1 tidak ditemukan.');
        }
        $data = IdvP204M::with('masterPenghasilan')
            ->where('id_individu_p1', $ididvp1)
            ->get(); 

        // $data = IdvP204M::where('id_individu_p1', $ididvp1)->get();
        $datap1 = IdvP1M::where('id', $ididvp1)->first();
        $masterPenghasilan = MasterPenghasilanM::all();


        return view('pages.individu.p2.p204idv', compact('data', 'datap1', 'masterPenghasilan'));
    }

    public function store(Request $request)
    {
        // dd($request->all());
        $idKgP1 = session('id_individu_p1');
        $userId = Auth::user()->id;

        $validated = $request->validate([
            'id_master_penghasilan' => 'required',
        ]);

        try {

            $p1 = IdvP204M::create([
                'id' => "IDVP204-" . strtotime(date("Y-m-d H:i:s")),
                'id_individu_p1' => $idKgP1,
                'id_master_penghasilan' => $validated['id_master_penghasilan'],
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'penghasilan' => $request->penghasilan,
                'diekspor' => $request->diekspor,
                'id_buat' => $userId,
                'id_update' => '',
                'tgl_buat' => now(),
                'tgl_update' => now(),
            ]);

            return redirect()->route('idv-p204.index')->with('success', 'Data berhasil disimpan.');
        } catch (\Throwable $e) {

            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p2: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = IdvP204M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP204M::find($id);

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

        return redirect()->back()->with('success', 'Data Individu P204 berhasil diperbarui');
    }

    public function destroy($id)
    {
        IdvP204M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data Individu P204 berhasil dihapus.');
    }
}
