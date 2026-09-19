<?php

namespace App\Http\Controllers\Api\Individu\P2;

use App\Http\Controllers\Controller;
use App\Models\Individu\P2\IdvP204M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Master\MasterPenghasilanM;

class P204IdvApi extends Controller
{
    public function index()
    {
        $data = IdvP204M::with([
            'individuP1',
            'masterPenghasilan'
        ])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P204 berhasil dimuat',
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

        $data = IdvP204M::create([
            'id' => "IDVP204-" . strtotime(date("Y-m-d H:i:s")),
            'id_individu_p1' => $request->id_individu_p1,
            'id_master_penghasilan' => $request->id_master_penghasilan,
            'jumlah' => $request->jumlah,
            'satuan' => $request->satuan,
            'penghasilan' => $request->penghasilan,
            'diekspor' => $request->diekspor,

            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $request->id_individu_p1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil disimpan',
            'data' => $data
        ]);
    }
    public function show($id)
    {
        $data = IdvP204M::findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil di Tampilkan',
            'data' => $data
        ]);
    }

    public function update(Request $request, $id)
    {
        $today = Carbon::now();
        $record = IdvP204M::find($id);

        if ($record) {
            $record->update([
                'id_master_penghasilan' => $request->id_master_penghasilan,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'penghasilan' => $request->penghasilan,
                'diekspor' => $request->diekspor,
                'id_update' => Auth::user()->id,
                'tgl_update' => $today
            ]);
            $idP1 = $record->id_individu_p1;
        } else {
            $idP1 = $request->id_individu_p1 ?? $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data Individu P204 berhasil di update',
            'data' => $record
        ]);
    }

    public function destroy($id)
    {
        $record = IdvP204M::where('id', $id)->first();
        if ($record) {
            $idP1 = $record->id_individu_p1;
            $record->delete();
        } else {
            // Jika ID yang dilempar adalah id_individu_p1
            IdvP204M::where('id_individu_p1', $id)->delete();
            $idP1 = $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P204',
            'individu_p204',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => "Data Individu P204 Berhasil Dihapus"
        ]);
    }

    public function showByIdP1($id)
    {
        $data = IdvP204M::with(['individuP1', 'masterPenghasilan'])
            ->where('id_individu_p1', $id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P204 berhasil dimuat',
            'data' => $data
        ]);
    }
    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P2\IdvP204M::where('id_individu_p1', $id_individu_p1)->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id_individu_p1,
                'P204',
                'individu_p204',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Semua data P204 berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
