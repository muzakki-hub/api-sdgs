<?php

namespace App\Http\Controllers\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P2\KgP2M;
use App\Models\Keluarga\P4\KgP422M;
use App\Models\Master\MasterFaskesM;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P422KgController extends Controller
{
    public function index()
    {
        $idKgP2 = session('id_kg_p2');

        $data = KgP422M::with('masterFaskes')
            ->where('id_kg_p2', $idKgP2)
            ->get();

        $datap2 = KgP2M::find($idKgP2);
        $masterfaskes = MasterFaskesM::all();

        return view('pages.keluarga.p4.kgp422', compact('data', 'datap2', 'masterfaskes'));
    }

    public function store(Request $request)
    {
        // dd(session($request->all()));
        $idKgP2 = session('id_kg_p2');
        $userId = Auth::user()->id;
        $datap2 = KgP2M::where('id', $idKgP2)->first();
        $request->validate([
            'id_master_faskes' => 'required',
        ]);

        try {
            KgP422M::create([
                'id' => "KGP422-" . strtotime(date("Y-m-d H:i:s")),
                'id_buat' => $userId,
                'id_survey' => $datap2->id_survey,
                'tgl_buat' => now(),
                'tgl_update' => now(),
                'id_kg_p2' => $idKgP2,

                // Data dari form
                'id_master_faskes' => $request->id_master_faskes,
                'jarak' => $request->jarak,
                'waktu_tempuh' => $request->waktu_tempuh,
                'kemudahan' => $request->kemudahan,
            ]);

            return redirect()->back()->with('success', 'Data keluarga P422 berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p4: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = KgP422M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = KgP422M::find($id);

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

        return redirect()->back()->with('success', 'Data keluarga P422 berhasil diperbarui');
    }

    public function destroy($id)
    {
        KgP422M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data keluarga P422 berhasil dihapus.');
    }
}
