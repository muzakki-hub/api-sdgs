<?php

namespace App\Http\Controllers\Api\Individu\P4;

use App\Http\Controllers\Controller;
use App\Models\Individu\P4\IdvP401M;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P401IdvApi extends Controller
{
    // ======================================================
    // GET SEMUA DATA P401
    // ======================================================
    public function index()
    {
        $data = IdvP401M::with([
            'individuP1',
            'masterPenyakit'
        ])->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berhasil dimuat',
            'data' => $data
        ]);
    }

    // ======================================================
    // SIMPAN DATA BARU
    // ======================================================
    public function store(Request $request)
    {
        $today = Carbon::now();
        $idP1 = $request->id_individu_p1;

        // Jika request berisi array 'data' (backward-compatibility)
        if ($request->has('data') && is_array($request->data)) {
            return $this->storeMany($request);
        }

        // Single record store (seperti P508 RT)
        if ($request->has('id_master_penyakit')) {
            $data = IdvP401M::create([
                'id' => "IDVP401-" . strtotime(date("Y-m-d H:i:s")) . "-" . random_int(100, 999),
                'id_individu_p1' => $idP1,
                'id_master_penyakit' => $request->id_master_penyakit,
                'status' => $request->input('status', '2'),
                'id_buat' => Auth::id() ?? '1750902135',
                'id_update' => Auth::id() ?? '1750902135',
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P401',
                'individu_p401',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P401 berhasil disimpan',
                'data' => $data
            ]);
        }

        // Single form style (seperti P403): simpan seluruh penyakit
        $masters = \App\Models\Master\MasterPenyakitM::orderBy('id')->get();
        IdvP401M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;
        $userId = Auth::id() ?? '1750902135';

        foreach ($masters as $m) {
            $val = $request->input($m->id, '2');
            if ($val !== '1' && $val !== '2') {
                $val = '2';
            }

            $rand = random_int(10000, 99999);
            $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP401M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_penyakit' => $m->id,
                'status' => $val,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P401',
            'individu_p401',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berhasil disimpan',
            'data' => $result
        ]);
    }


    // ======================================================
    // SIMPAN BANYAK DATA P401 SEKALIGUS
    // ======================================================
    public function storeMany(Request $request)
    {
        // Pastikan "data" ada dan berupa array
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request tidak memiliki field data[] yang valid'
            ], 400);
        }

        $today = Carbon::now();
        $result = [];
        $counter = 1;
        $idP1 = null;
        foreach ($request->data as $row) {
            // Cek setiap item wajib punya field yang dibutuhkan
            if (
                !isset($row['id_individu_p1']) ||
                !isset($row['id_master_penyakit']) ||
                !isset($row['status'])
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'Setiap item dalam data[] harus punya id_individu_p1, id_master_penyakit, status'
                ], 422);
            }
            $idP1 = $row['id_individu_p1'];
            $rand = random_int(10000, 99999);

            // id final <= 25 karakter
            $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP401M::create([
                'id' => $id_final,
                'id_individu_p1' => $row['id_individu_p1'],
                'id_master_penyakit' => $row['id_master_penyakit'],
                'status' => $row['status'],

                'id_buat' => Auth::user()->id,
                'id_update' => Auth::user()->id,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
        }

        if ($idP1) {
            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P401',
                'individu_p401',
                'id_individu_p1'
            );
        }

        return response()->json([
            'status' => true,
            'message' => 'Semua data P401 berhasil disimpan',
            'data' => $result
        ]);
    }


    // ======================================================
    // DETAIL SATU DATA
    // ======================================================
    public function show($id)
    {
        $data = IdvP401M::with(['individuP1', 'masterPenyakit'])
            ->findOrFail($id);

        return response()->json([
            'status' => true,
            'message' => 'Detail P401 berhasil dimuat',
            'data' => $data
        ]);
    }

    // ======================================================
    // UPDATE DATA
    // ======================================================
    public function update(Request $request, $id)
    {
        $today = Carbon::now();

        // 1. Jika request berisi array 'data' (backward-compatibility)
        if ($request->has('data') && is_array($request->data)) {
            IdvP401M::where('id_individu_p1', $id)->delete();
            $result = [];
            $counter = 1;
            $userId = Auth::id() ?? '1750902135';

            foreach ($request->data as $row) {
                $rand = random_int(10000, 99999);
                $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

                $save = IdvP401M::create([
                    'id' => $id_final,
                    'id_individu_p1' => $id,
                    'id_master_penyakit' => $row['id_master_penyakit'],
                    'status' => $row['status'],
                    'id_buat' => $userId,
                    'id_update' => $userId,
                    'tgl_buat' => $today,
                    'tgl_update' => $today,
                ]);

                $result[] = $save;
                $counter++;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id,
                'P401',
                'individu_p401',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P401 berhasil diupdate',
                'data' => $result
            ]);
        }

        // 2. Single-record update jika hanya update 1 id_master_penyakit spesifik
        if ($request->has('id_master_penyakit')) {
            $record = IdvP401M::find($id);
            if ($record) {
                $record->update([
                    'id_master_penyakit' => $request->id_master_penyakit ?? $record->id_master_penyakit,
                    'status' => $request->status ?? $record->status,
                    'id_update' => Auth::id() ?? '1750902135',
                    'tgl_update' => $today,
                ]);
                $idP1 = $record->id_individu_p1;
            } else {
                $idP1 = $request->id_individu_p1 ?? $id;
            }

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $idP1,
                'P401',
                'individu_p401',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P401 berhasil diupdate',
                'data' => $record
            ]);
        }

        // 3. Single-form questionnaire (seperti P403): simpan seluruh master penyakit
        $idP1 = $request->id_individu_p1 ?? $id;
        $masters = \App\Models\Master\MasterPenyakitM::orderBy('id')->get();
        IdvP401M::where('id_individu_p1', $idP1)->delete();

        $result = [];
        $counter = 1;
        $userId = Auth::id() ?? '1750902135';

        foreach ($masters as $m) {
            $val = $request->input($m->id, '2');
            if ($val !== '1' && $val !== '2') {
                $val = '2';
            }

            $rand = random_int(10000, 99999);
            $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP401M::create([
                'id' => $id_final,
                'id_individu_p1' => $idP1,
                'id_master_penyakit' => $m->id,
                'status' => $val,
                'id_buat' => $userId,
                'id_update' => $userId,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P401',
            'individu_p401',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berhasil diupdate',
            'data' => $result
        ]);
    }

    public function updateMany(Request $request, $id_p1)
    {
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request tidak memiliki field data[] yang valid'
            ], 400);
        }

        // Hapus semua data lama
        IdvP401M::where('id_individu_p1', $id_p1)->delete();

        $today = Carbon::now();
        $result = [];
        $counter = 1;

        foreach ($request->data as $row) {

            $rand = random_int(10000, 99999);
            $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP401M::create([
                'id' => $id_final,
                'id_individu_p1' => $id_p1,
                'id_master_penyakit' => $row['id_master_penyakit'],
                'status' => $row['status'],

                'id_buat' => Auth::user()->id,
                'id_update' => Auth::user()->id,
                'tgl_buat' => $today,
                'tgl_update' => $today,
            ]);

            $result[] = $save;
            $counter++;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $id_p1,
            'P401',
            'individu_p401',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berhasil diupdate',
            'data' => $result
        ]);
    }


    // ======================================================
    // HAPUS DATA
    // ======================================================
    public function destroy($id)
    {
        $record = IdvP401M::where('id', $id)->first();
        if ($record) {
            $idP1 = $record->id_individu_p1;
            $record->delete();
        } else {
            // Jika ID yang dikirim adalah id_individu_p1
            IdvP401M::where('id_individu_p1', $id)->delete();
            $idP1 = $id;
        }

        app(\App\Services\SurveyProgressService::class)->syncProgress(
            $idP1,
            'P401',
            'individu_p401',
            'id_individu_p1'
        );

        return response()->json([
            'status' => true,
            'message' => "Data P401 berhasil dihapus"
        ]);
    }

    // ======================================================
    // LOAD DATA BERDASARKAN ID P1
    // ======================================================
    public function showByIdP1($id)
    {
        $records = IdvP401M::where('id_individu_p1', $id)->get();

        $formData = [
            'id_individu_p1' => $id,
            'id' => $id,
        ];
        foreach ($records as $r) {
            $formData[$r->id_master_penyakit] = (string) $r->status;
        }

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berdasarkan ID P1 berhasil dimuat',
            'data' => $formData,
            'raw_records' => $records,
        ]);
    }

    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P4\IdvP401M::where('id_individu_p1', $id_individu_p1)->delete();

            app(\App\Services\SurveyProgressService::class)->syncProgress(
                $id_individu_p1,
                'P401',
                'individu_p401',
                'id_individu_p1'
            );

            return response()->json([
                'status' => true,
                'message' => 'Semua data P401 berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
