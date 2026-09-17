<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP421M;
use Throwable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class P421Api extends Controller
{
    public function showByIdP2($id)
    {
        $data = KgP421M::where('id_kg_p2', $id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berdasarkan ID P2',
            'data' => $data
        ]);
    }

    public function index(Request $request)
    {
        try {
            $idKgP2 = $request->id_kg_p2;

            $data = KgP421M::with('pendidikan')
                ->where('id_kg_p2', $idKgP2)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Success fetch data',
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            Log::error('P421 Index Error: ' . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Internal server error',
            ], 500);
        }
    }

    // =============================
    // STORE (PERBAIKAN TOTAL)
    // =============================
    public function store(Request $request)
    {
        $request->validate([
            'id_kg_p2' => 'required',
            'id_master_pendidikan' => 'required'
        ]);

        DB::beginTransaction();

        try {
            $idKgP2 = $request->id_kg_p2;
            $userId = Auth::user()->id;
            $datap2 = KgP2M::find($idKgP2);

            if (!$datap2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P2 tidak ditemukan'
                ], 404);
            }

            // ============================
            // 🔥 FIX UTAMA: GUNAKAN ID UNIK
            // ============================
            $uniqueId = "KGP421-" . strtoupper(bin2hex(random_bytes(6)));

            $data = KgP421M::create([
                'id' => $uniqueId,
                'id_buat' => $userId,
                'id_survey' => $datap2->id_survey,
                'tgl_buat' => now(),
                'tgl_update' => now(),
                'id_kg_p2' => $idKgP2,
                'id_master_pendidikan' => $request->id_master_pendidikan,
                'jarak' => $request->jarak,
                'waktu_tempuh' => $request->waktu_tempuh,
                'kemudahan' => $request->kemudahan,
            ]);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'P421 berhasil ditambahkan',
                'data' => $data
            ], 201);
        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error("P421 Store Error: " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data'
            ], 500);
        }
    }

    // =============================
    // SHOW
    // =============================
    public function show($id)
    {
        try {
            $data = KgP421M::findOrFail($id);

            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } catch (\Throwable $e) {
            Log::error("P421 Show Error: {$e->getMessage()}");
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }
    }

    // =============================
    // UPDATE
    // =============================
    public function update(Request $request, $id)
    {
        DB::beginTransaction();

        try {
            $data = KgP421M::find($id);

            if (!$data) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan'
                ], 404);
            }

            $data->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => Carbon::now()
                ]
            ));

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data P421 berhasil diperbarui',
                'data' => $data
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error("P421 Update Error: " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui data'
            ], 500);
        }
    }

    // =============================
    // DELETE
    // =============================
    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            KgP421M::findOrFail($id)->delete();

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Data P421 berhasil dihapus'
            ]);
        } catch (\Throwable $e) {

            DB::rollBack();
            Log::error("P421 Delete Error: " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data'
            ], 500);
        }
    }
}
