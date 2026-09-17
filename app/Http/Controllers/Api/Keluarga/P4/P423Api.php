<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP423M;
use Illuminate\Support\Facades\Log;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class P423Api extends Controller
{

    public function showByIdP2($id)
    {
        $data = KgP423M::where('id_kg_p2', $id)->get();

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

            if (!$idKgP2) {
                return response()->json([
                    'status' => false,
                    'message' => 'Parameter id_kg_p2 diperlukan.'
                ], 400);
            }

            $data = KgP423M::with('masterNakes')
                ->where('id_kg_p2', $idKgP2)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P423 INDEX] " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    /**
     * POST /api/kg/p423
     */
    public function store(Request $request)
{
    // Normalisasi payload: bisa single object atau array of objects
    $payload = $request->items ?? [];
    if (!is_array($payload)) {
        return response()->json([
            'status' => false,
            'message' => 'Payload harus berupa object atau array objek.'
        ], 422);
    }

    // Jika payload adalah satu object (associative) bukan numeric-indexed array, bungkus jadi array
    if ($payload === [] || array_keys($payload) !== range(0, count($payload) - 1)) {
        // payload mungkin associative (single object) -> ubah menjadi array berisi 1 item
        $payload = [$payload];
    }

    // Validator: cek setiap item wajib punya id_kg_p2 dan id_master_faskes (sesuai JSON input)
    $validator = Validator::make(
        ['data' => $payload],
        [
            'data.*.id_kg_p2' => 'required|string',
            'data.*.id_master_faskes' => 'required', // we'll map this to id_master_tenkes
            'data.*.jarak' => 'nullable',
            'data.*.waktu_tempuh' => 'nullable',
            'data.*.kemudahan' => 'nullable',
        ]
    );

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validasi gagal.',
            'errors' => $validator->errors()
        ], 422);
    }

    DB::beginTransaction();
    try {
        $created = [];
        foreach ($payload as $item) {
            // pastikan id_kg_p2 valid (ada di P2)
            $datap2 = KgP2M::find($item['id_kg_p2']);
            if (!$datap2) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "id_kg_p2 tidak ditemukan: {$item['id_kg_p2']}"
                ], 404);
            }

            // generate id unik (microtime + random) supaya hampir mustahil bentrok
            $generatedId = 'KGP423-' . str_replace('.', '', microtime(true)) . rand(10, 99);

            // map input field name id_master_faskes -> id_master_tenkes (kolom DB)
            $idMasterTenkes = $item['id_master_faskes'] ?? $item['id_master_tenkes'] ?? null;

            $row = KgP423M::create([
                'id' => $generatedId,
                'id_kg_p2' => $item['id_kg_p2'],
                'id_master_tenkes' => $idMasterTenkes,
                'jarak' => $item['jarak'] ?? null,
                'waktu_tempuh' => $item['waktu_tempuh'] ?? null,
                'kemudahan' => $item['kemudahan'] ?? null,

                'id_survey' => $datap2->id_survey,
                'id_buat' => Auth::id(),
                'id_update' => Auth::id(),
                'tgl_buat' => now(),
                'tgl_update' => now(),
            ]);

            $created[] = $row;
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil ditambahkan.',
            'data' => $created
        ], 201);
    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error("[P423 STORE] " . $e->getMessage());
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan server.'
        ], 500);
    }
}

    /**
     * GET /api/kg/p423/{id}
     */
    public function show($id)
    {
        $data = KgP423M::with('masterNakes')->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data.',
            'data' => $data
        ], 200);
    }

    /**
     * PUT/PATCH /api/kg/p423/{id}
     */
   public function update(Request $request, $id)
{
    try {

        // Cek apakah datanya ada
        $data = KgP423M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        // Update data
        $data->update(array_merge(
            $request->all(),
            [
                'id_update' => Auth::id(),
                'tgl_update' => now()
            ]
        ));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.',
            'data' => $request->all()
        ], 200);

    } catch (\Throwable $e) {

        // Log error untuk debugging
        Log::error('ERROR UPDATE P423: ' . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan pada server.',
            'error' => $e->getMessage()   // boleh dihapus jika tidak ingin tampil di API
        ], 500);
    }
}


    /**
     * DELETE /api/kg/p423/{id}
     */
    public function destroy($id)
    {
        $data = KgP423M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil dihapus.'
        ], 200);
    }
}
