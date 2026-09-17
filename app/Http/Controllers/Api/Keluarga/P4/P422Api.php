<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP422M;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Support\Facades\Auth;
use Throwable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class P422Api extends Controller
{
 // GET /api/keluarga/p422?id_kg_p2=xx
    public function index(Request $request)
    {
        if (!$request->id_kg_p2) {
            return response()->json([
                'status' => false,
                'message' => 'Parameter id_kg_p2 diperlukan.'
            ], 400);
        }

        try {
            $data = KgP422M::with('masterFaskes')
                ->where('id_kg_p2', $request->id_kg_p2)
                ->get();

            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan.',
                'data' => $data
            ], 200);

        } catch (\Throwable $e) {
            Log::error("P422 INDEX ERROR: " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server.'
            ], 500);
        }
    }

    // POST /api/keluarga/p422
 public function store(Request $request)
{
    // Validasi array of objects
    // $request->validate([
    //     '*.id_kg_p2'        => 'required|exists:kg_p2,id',
    //     '*.id_master_faskes'=> 'required|integer',
    //     '*.jarak'           => 'nullable|numeric',
    //     '*.waktu_tempuh'    => 'nullable|numeric',
    //     '*.kemudahan'       => 'required|in:1,2',
    // ]);

    $items = $request->items ?? [];


    if (empty($items)) {
        return response()->json([
            'status' => false,
            'message' => 'Tidak ada data yang dikirim.'
        ], 400);
    }

    DB::beginTransaction();

    try {
        $now = now();
        $userId = Auth::id();

        $rows = [];
        $uniqueId = "KGP422-" . strtotime(date("Y-m-d H:i:s"));
        foreach ($items as $index => $item) {
            // pastikan index/format OK
            if (!isset($item['id_kg_p2'])) {
                throw new \Exception("Item pada index {$index} tidak memiliki id_kg_p2");
            }

            // ambil p2 (untuk id_survey)
            $p2 = KgP2M::find($item['id_kg_p2']);
            if (!$p2) {
                // validasi awal sudah memeriksa exists, tapi double-check aman
                throw new \Exception("KgP2 dengan id '{$item['id_kg_p2']}' tidak ditemukan.");
            }

            $rows[] = [
                'id'               => $uniqueId . "-" . ($index + 1),
                'id_kg_p2'         => $item['id_kg_p2'],
                'id_master_faskes' => $item['id_master_faskes'],
                'jarak'            => $item['jarak'] ?? null,
                'waktu_tempuh'     => $item['waktu_tempuh'] ?? null,
                'kemudahan'        => $item['kemudahan'],
                // 'id_survey'        => $p2->id_survey,
                'id_buat'          => $userId,
                'id_update'        => $userId,
                'tgl_buat'         => $now,
                'tgl_update'       => $now,
            ];
        }

        // Periksa apakah model menggunakan nama tabel yang sesuai.
        // Gunakan insert massal (efisien). Pastikan kolom yang dipakai sesuai.
        KgP422M::insert($rows);

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Semua data P422 berhasil disimpan.',
            'inserted' => count($rows)
        ], 201);

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error("P422 STORE ERROR: " . $e->getMessage(), [
            'exception' => $e,
            'payload_sample' => isset($items[0]) ? $items[0] : null
        ]);

        return response()->json([
            'status' => false,
            'message' => 'Terjadi kesalahan server.',
            'error' => $e->getMessage()
        ], 500);
    }
}

    // GET /api/keluarga/p422/{id}
    public function show($id)
    {
        $data = KgP422M::with('masterFaskes')->find($id);

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

    public function storeBatch(Request $request)
{
    $request->validate([
        'id_kg_p2' => 'required|exists:kg_p2,id',
        'items' => 'required|array|min:1',
        'items.*.id_master_faskes' => 'required|integer|exists:master_faskes,id',
        'items.*.jarak' => 'nullable|numeric',
        'items.*.waktu_tempuh' => 'nullable|numeric',
        'items.*.kemudahan' => 'required|in:1,2',
    ]);

    try {
        $p2 = KgP2M::find($request->id_kg_p2);

        DB::beginTransaction();

        foreach ($request->items as $item) {
            KgP422M::create([
                'id_kg_p2'        => $request->id_kg_p2,
                'id_master_faskes' => $item['id_master_faskes'],
                'jarak'           => $item['jarak'] ?? null,
                'waktu_tempuh'    => $item['waktu_tempuh'] ?? null,
                'kemudahan'       => $item['kemudahan'],

                // 'id_survey'       => $p2->id_survey,
                'id_buat'         => Auth::id(),
                'id_update'       => Auth::id(),
                'tgl_buat'        => now(),
                'tgl_update'      => now(),
            ]);
        }

        DB::commit();

        return response()->json([
            'status' => true,
            'message' => 'Semua data P422 berhasil disimpan.',
        ], 201);

    } catch (\Throwable $e) {
        DB::rollBack();
        Log::error("P422 BATCH ERROR: " . $e->getMessage());

        return response()->json([
            'status' => false,
            'message' => 'Gagal menyimpan data batch.'
        ], 500);
    }
}


    // PUT /api/keluarga/p422/{id}
    public function update(Request $request, $id)
    {
        $data = KgP422M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan.'
            ], 404);
        }

        $data->update(array_merge($request->all(), [
            'id_update' => Auth::id(),
            'tgl_update' => now(),
        ]));

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil diperbarui.',
            'data' => $data
        ], 200);
    }

    // DELETE /api/keluarga/p422/{id}
    public function destroy($id)
    {
        $data = KgP422M::find($id);

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

    public function showByIdP2($id)
    {
        $data = KgP422M::where('id_kg_p2', $id)->get();

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berdasarkan ID P2',
            'data' => $data
        ]);
    }
}
