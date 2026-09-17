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

        $data = IdvP401M::create([
            'id' => "IDVP401-" . strtotime(now()) . "-" . rand(100, 999),
            'id_individu_p1' => $request->id_individu_p1,
            'id_master_penyakit' => $request->id_master_penyakit,
            'status' => $request->status,

            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => $today,
            'tgl_update' => $today
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berhasil disimpan',
            'data' => $data
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
        if (!$request->has('data') || !is_array($request->data)) {
            return response()->json([
                'status' => false,
                'message' => 'Request tidak memiliki field data[] yang valid'
            ], 400);
        }

        // Hapus semua data lama berdasarkan id_individu_p1
        IdvP401M::where('id_individu_p1', $id)->delete();

        $today = Carbon::now();
        $result = [];
        $counter = 1;

        foreach ($request->data as $row) {

            $rand = random_int(10000, 99999);
            $id_final = "IDVP401-" . $rand . "-" . str_pad($counter, 2, "0", STR_PAD_LEFT);

            $save = IdvP401M::create([
                'id' => $id_final,
                'id_individu_p1' => $id,
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
        IdvP401M::findOrFail($id)->delete();

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
        $data = IdvP401M::with(['individuP1', 'masterPenyakit'])
            ->where('id_individu_p1', $id)
            ->get();

        return response()->json([
            'status' => true,
            'message' => 'Data P401 berdasarkan ID P1 berhasil dimuat',
            'data' => $data
        ]);
    }

    public function deleteAllByP1($id_individu_p1)
    {
        try {
            \App\Models\Individu\P4\IdvP401M::where('id_individu_p1', $id_individu_p1)->delete();

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
