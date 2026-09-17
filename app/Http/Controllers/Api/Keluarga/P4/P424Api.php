<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP424M;
use Illuminate\Support\Facades\Log;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class P424Api extends Controller
{

    public function showByIdP2($id)
    {
        $data = KgP424M::where('id_kg_p2', $id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berdasarkan ID P2',
            'data' => $data
        ]);
    }

    // GET LIST DATA
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

            $data = KgP424M::with('masterApst')
                ->where('id_kg_p2', $idKgP2)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);
        } catch (\Throwable $e) {
            Log::error('[P4-424-INDEX] ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // CREATE DATA
    public function store(Request $request)
{
    // Ambil seluruh payload
    $payload = $request->items ?? [];

    // Jika payload 1 object (associative), bungkus jadi array
    if (!is_array($payload)) {
        return response()->json([
            'status' => false,
            'message' => 'Payload harus berupa array objek.'
        ], 422);
    }
    if ($payload === [] || array_keys($payload) !== range(0, count($payload) - 1)) {
        $payload = [$payload];
    }

    // Validasi array item per item
    $validator = Validator::make(
        ['data' => $payload],
        [
            'data.*.id_kg_p2' => 'required|string',
            'data.*.id_master_akses_sarpras' => 'required|integer',
            'data.*.jenis_transportasi' => 'nullable',
            'data.*.penggunaan_transportasi' => 'nullable',
            'data.*.biaya_sekali' => 'nullable',
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

            $datap2 = KgP2M::find($item['id_kg_p2']);
            if (!$datap2) {
                DB::rollBack();
                return response()->json([
                    'status' => false,
                    'message' => "id_kg_p2 tidak ditemukan: {$item['id_kg_p2']}"
                ], 404);
            }

            // Generate ID super unik
            $generatedId = "KGP424-" . str_replace('.', '', microtime(true)) . rand(10, 99);

            $row = KgP424M::create([
                'id' => $generatedId,
                'id_buat' => Auth::id() ?? null,
                'id_survey' => $datap2->id_survey,
                'tgl_buat' => now(),
                'tgl_update' => now(),
                'id_kg_p2' => $item['id_kg_p2'],

                'id_master_akses_sarpras' => $item['id_master_akses_sarpras'],
                'jenis_transportasi' => $item['jenis_transportasi'] ?? null,
                'penggunaan_transportasi' => $item['penggunaan_transportasi'] ?? null,
                'biaya_sekali' => $item['biaya_sekali'] ?? null,
                'waktu_tempuh' => $item['waktu_tempuh'] ?? null,
                'kemudahan' => $item['kemudahan'] ?? null,
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
        Log::error("[P424 STORE ARRAY] " . $e->getMessage());
        
        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan server.'
        ], 500);
    }
}


    // SHOW DETAIL
    public function show($id)
    {
        $data = KgP424M::with('masterApst')->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data ditemukan.',
            'data' => $data
        ], 200);
    }

    // UPDATE DATA
    public function update(Request $request, $id)
    {
        $data = KgP424M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->update(array_merge(
            $request->all(),
            [
                'id_update' => Auth::id(),
                'tgl_update' => Carbon::now(),
            ]
        ));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.',
            'data' => $data
        ], 200);
    }

    // DELETE DATA
    public function destroy($id)
    {
        $data = KgP424M::find($id);

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
