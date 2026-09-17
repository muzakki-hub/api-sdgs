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
        $data = IdvP402M::with(['masterSarkes'])
            ->where('id_individu_p1', $id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berdasarkan ID P1 berhasil dimuat',
            'data' => $data
        ]);
    }

    // ======================================================
    // SIMPAN SATU DATA (STORE)
    // ======================================================
    public function store(Request $request)
    {
        $today = Carbon::now();

        $save = IdvP402M::create([
            'id' => "IDVP402-" . strtotime(now()) . "-" . rand(100, 999),
            'id_individu_p1' => $request->id_individu_p1,
            'id_master_sarkes' => $request->id_master_sarkes,
            'jml_berkunjung' => $request->jml_berkunjung,
            'id_buat' => Auth::id(),
            'id_update' => Auth::id(),
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berhasil ditambahkan',
            'data' => $save
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

        foreach ($request->data as $row) {

            if (
                !isset($row['id_individu_p1']) ||
                !isset($row['id_master_sarkes']) ||
                !isset($row['jml_berkunjung'])
            ) {
                continue; // skip jika tidak lengkap
            }

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
    public function update(Request $request, $id_p1)
    {
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request harus berisi data[]'
            ], 400);
        }

        // hapus semua lama
        IdvP402M::where('id_individu_p1', $id_p1)->delete();

        $today = Carbon::now();
        $result = [];
        $counter = 1;

        foreach ($request->data as $row) {
            if (!isset($row['id_master_sarkes']) || !isset($row['jml_berkunjung'])) {
                continue;
            }

            $rand = random_int(10000, 99999);
            $id_final = "IDVP402-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP402M::create([
                'id' => $id_final,
                'id_individu_p1' => $id_p1,
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

        if (!$del) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $del->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data P402 berhasil dihapus'
        ]);
    }
    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P4\IdvP402M::where('id_individu_p1', $id_individu_p1)->delete();

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
