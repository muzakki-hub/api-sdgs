<?php

namespace App\Http\Controllers\Api\Individu\P4;

use App\Http\Controllers\Controller;
use App\Models\Individu\P4\IdvP4M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P4IdvApi extends Controller
{
    /**
     * Tampilkan semua data P4
     */
    public function index()
    {
        $data = IdvP4M::all();

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Simpan data baru P4
     */
    public function store(Request $request)
    {
        $today = Carbon::now();

        $data = IdvP4M::create([
            'id' => "IDVP4-" . strtotime(now()),
            'id_individu_p1' => $request->id_individu_p1,

            // Kolom disabilitas
            'tunanetra' => $request->tunanetra,
            'tunarungu' => $request->tunarungu,
            'tunawicara' => $request->tunawicara,
            'tunarungu_wicara' => $request->{"tunarungu_wicara"}, // ← tambahkan ini
            'tunadaksa' => $request->tunadaksa,
            'tunagrahita' => $request->tunagrahita,
            'tunalaras' => $request->tunalaras,
            'cacat_eks_sakitkusta' => $request->cacat_eks_sakitkusta,
            'cacat_ganda' => $request->cacat_ganda,
            'dipasung' => $request->dipasung,

            // Metadata
            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil disimpan',
            'data' => $data
        ]);
    }

    /**
     * Tampilkan data berdasarkan ID
     */
    public function show($id)
    {
        $data = IdvP4M::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil ditampilkan',
            'data' => $data
        ]);
    }

    /**
     * Update data P4
     */
    public function update(Request $request, $id)
    {
        $today = Carbon::now();

        $data = IdvP4M::where('id', $id)->update([
            'tunanetra' => $request->tunanetra,
            'tunarungu' => $request->tunarungu,
            'tunawicara' => $request->tunawicara,
            'tunarungu_wicara' => $request->{"tunarungu_wicara"}, // ← tambahkan ini
            'tunadaksa' => $request->tunadaksa,
            'tunagrahita' => $request->tunagrahita,
            'tunalaras' => $request->tunalaras,
            'cacat_eks_sakitkusta' => $request->cacat_eks_sakitkusta,
            'cacat_ganda' => $request->cacat_ganda,
            'dipasung' => $request->dipasung,

            'id_update' => Auth::user()->id,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berhasil diupdate',
            'data' => $data
        ]);
    }

    /**
     * Hapus data
     */
    public function destroy($id)
    {
        IdvP4M::findOrFail($id)->delete();

        return response()->json([
            'status' => true,
            'message' => "Data Individu P4 berhasil dihapus"
        ]);
    }

    /**
     * Tampilkan data berdasarkan ID P1
     */
    public function showByIdP1($id)
    {
        $data = IdvP4M::where('id_individu_p1', $id)->first();

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P4 berdasarkan ID P1',
            'data' => $data
        ]);
    }
}
