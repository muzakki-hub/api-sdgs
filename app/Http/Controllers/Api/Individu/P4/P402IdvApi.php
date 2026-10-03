<?php

namespace App\Http\Controllers\Api\Individu\P4;

use App\Http\Controllers\Controller;
use App\Models\Individu\P4\IdvP402M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P402IdvApi extends Controller
{
    // ======================================================
    // GET SEMUA DATA
    // ======================================================
    public function index()
    {
        $data = IdvP402M::with(['individuP1', 'masterSarkes'])->get();

        return response()->json([
            'status' => true,
            'message' => 'Seluruh data P402 berhasil dimuat',
            'data' => $data
        ]);
    }

    // ======================================================
    // GET DETAIL BY ID RECORD
    // ======================================================
    public function show($id)
    {
        $data = IdvP402M::with(['individuP1', 'masterSarkes'])->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data P402 berhasil dimuat',
            'data' => $data
        ]);
    }

    // ======================================================
    // GET DATA BERDASARKAN ID P1
    // ======================================================
    public function showByIdP1($id)
    {
        $records = IdvP402M::where('id_individu_p1', $id)->get();

        $formData = [
            'id_individu_p1' => $id,
            'id' => $id,
        ];
        foreach ($records as $r) {
            $formData[$r->id_master_sarkes] = (int) $r->jml_berkunjung;
        }

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berdasarkan ID P1 berhasil dimuat',
            'data' => $formData,
            'raw_records' => $records,
        ]);
    }

    // ======================================================
    // SIMPAN SATU DATA (STORE)
    // ======================================================
    public function store(Request $request)
    {
        $today = Carbon::now();
        $idP1 = $request->id_individu_p1;

        if ($request->has('data') && is_array($request->data)) {
            return $this->storeMany($request);
        }

        // Single record store (seperti P508 RT)
        if ($request->has('id_master_sarkes')) {
            $data = IdvP402M::create([
                'id' => "IDVP402-" . strtotime(date("Y-m-d H:i:s")) . "-" . random_int(100, 999),
                'id_individu_p1' => $idP1,
                'id_master_sarkes' => $request->id_master_sarkes,
                'jml_berkunjung' => (int) $request->input('jml_berkunjung', 0),
                'id_buat' => Auth::id() ?? '1750902135',
                'id_update' => Auth::id() ?? '1750902135',
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P402',
                'individu_p402',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P402 berhasil disimpan',
                'data' => $data
            ]);
        }

        // Single form style (seperti P403): simpan seluruh faskes
        $masters = \App\Models\Master\MasterSarkesM::orderBy('id')->get();
        IdvP402M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;
        $userId = Auth::id() ?? '1750902135';

        foreach ($masters as $m) {
            $val = $request->input($m->id, 0);
            if ($val === null || $val === '' || !is_numeric($val)) {
                $val = 0;
            }

            $rand = random_int(10000, 99999);
            $id_final = "IDVP402-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP402M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_sarkes' => $m->id,
                'jml_berkunjung' => (int) $val,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P402',
            'individu_p402',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berhasil disimpan',
            'data' => $result
        ]);
    }

    // ======================================================
    // SIMPAN BANYAK DATA (STORE MANY)
    // ======================================================
    public function storeMany(Request $request)
    {
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request harus berisi data[]'
            ], 400);
        }

        $today = Carbon::now();
        $result = [];
        $counter = 1;
        $idP1 = null;

        foreach ($request->data as $row) {

            if (
                !isset($row['id_individu_p1']) ||
                !isset($row['id_master_sarkes']) ||
                !isset($row['jml_berkunjung'])
            ) {
                continue; // skip jika tidak lengkap
            }

            $idP1 = $row['id_individu_p1'];
            $rand = random_int(10000, 99999);
            $id_final = "IDVP402-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP402M::create([
                'id' => $id_final,
                'id_individu_p1' => $row['id_individu_p1'],
                'id_master_sarkes' => $row['id_master_sarkes'],
                'jml_berkunjung' => $row['jml_berkunjung'],
                'id_buat' => Auth::id(),
                'id_update' => Auth::id(),
                'tgl_buat' => $today,
                'tgl_update' => $today
            ]);

            $result[] = $save;
            $counter++;
        }

        if ($idP1) {
            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P402',
                'individu_p402',
                'id_individu_p1'
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Semua data P402 berhasil disimpan',
            'data' => $result
        ]);
    }

    // ======================================================
    // UPDATE DATA BERDASARKAN ID P1
    // (HAPUS SEMUA → INSERT ULANG)  — SAMA FORMAT DENGAN P401
    // ======================================================
    public function update(Request $request, $id)
    {
        $today = Carbon::now();

        // 1. Jika request berisi array 'data' (backward-compatibility)
        if ($request->has('data') && is_array($request->data)) {
            IdvP402M::where('id_individu_p1', $id)->delete();
            $result = [];
            $counter = 1;
            $userId = Auth::id() ?? '1750902135';

            foreach ($request->data as $row) {
                if (!isset($row['id_master_sarkes']) || !isset($row['jml_berkunjung'])) {
                    continue;
                }

                $rand = random_int(10000, 99999);
                $id_final = "IDVP402-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

                $save = IdvP402M::create([
                    'id' => $id_final,
                    'id_individu_p1' => $id,
                    'id_master_sarkes' => $row['id_master_sarkes'],
                    'jml_berkunjung' => $row['jml_berkunjung'],
                    'id_buat' => $userId,
                    'id_update' => $userId,
                    'tgl_buat' => $today,
                    'tgl_update' => $today
                ]);

                $result[] = $save;
                $counter++;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id,
                'P402',
                'individu_p402',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P402 berhasil diperbarui',
                'data' => $result
            ]);
        }

        // 2. Single-record update jika hanya update 1 id_master_sarkes spesifik
        if ($request->has('id_master_sarkes')) {
            $record = IdvP402M::find($id);
            if ($record) {
                $record->update([
                    'id_master_sarkes' => $request->id_master_sarkes ?? $record->id_master_sarkes,
                    'jml_berkunjung' => $request->jml_berkunjung ?? $record->jml_berkunjung,
                    'id_update' => Auth::id() ?? '1750902135',
                    'tgl_update' => $today
                ]);
                $idP1 = $record->id_individu_p1;
            } else {
                $idP1 = $request->id_individu_p1 ?? $id;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P402',
                'individu_p402',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P402 berhasil diperbarui',
                'data' => $record
            ]);
        }

        // 3. Single-form questionnaire (seperti P403): simpan seluruh master sarkes
        $idP1 = $request->id_individu_p1 ?? $id;
        $masters = \App\Models\Master\MasterSarkesM::orderBy('id')->get();
        IdvP402M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;
        $userId = Auth::id() ?? '1750902135';

        foreach ($masters as $m) {
            $val = $request->input($m->id, 0);
            if ($val === null || $val === '' || !is_numeric($val)) {
                $val = 0;
            }

            $rand = random_int(10000, 99999);
            $id_final = "IDVP402-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP402M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_sarkes' => $m->id,
                'jml_berkunjung' => (int) $val,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P402',
            'individu_p402',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berhasil diperbarui',
            'data' => $result
        ]);
    }

    // ======================================================
    // HAPUS SATU DATA
    // ======================================================
    public function destroy($id)
    {
        $del = IdvP402M::find($id);

        if ($del) {
            $idP1 = $del->id_individu_p1;
            $del->delete();
        } else {
            // Jika ID yang dikirim adalah id_individu_p1
            IdvP402M::where('id_individu_p1', $id)->delete();
            $idP1 = $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P402',
            'individu_p402',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berhasil dihapus'
        ]);
    }
    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P4\IdvP402M::where('id_individu_p1', $id_individu_p1)->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id_individu_p1,
                'P402',
                'individu_p402',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Semua data P402 berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
