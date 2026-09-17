<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP424M;
use App\Models\Keluarga\P2\KgP2M;
use App\Services\SurveyProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P424Api extends Controller
{
    public const SARPRAS_MAP = [
        'A001' => '1',
        'A002' => '2',
        'A003' => '3',
        'A004' => '4',
        'A005' => '5',
        'A006' => '6',
    ];

    public function showByIdP2($id)
    {
        try {
            $rows = KgP424M::where('id_kg_p2', $id)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P424 belum ada',
                    'data' => null,
                ], 404);
            }

            $flat = [
                'id' => $id,
                'id_kg_p2' => $id,
            ];

            foreach ($rows as $row) {
                $suffix = self::SARPRAS_MAP[$row->id_master_akses_sarpras] ?? null;
                if ($suffix) {
                    $flat["jenis_transportasi_{$suffix}"] = $row->jenis_transportasi;
                    $flat["penggunaan_transportasi_{$suffix}"] = $row->penggunaan_transportasi;
                    $flat["waktu_tempuh_{$suffix}"] = $row->waktu_tempuh;
                    $flat["biaya_sekali_{$suffix}"] = $row->biaya_sekali;
                    $flat["kemudahan_{$suffix}"] = $row->kemudahan;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data P424 ditemukan',
                'data' => $flat,
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P424 SHOW] " . $e->getMessage());
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan server',
            ], 500);
        }
    }

    public function index(Request $request)
    {
        return $this->showByIdP2($request->id_kg_p2);
    }

    public function show($id)
    {
        return $this->showByIdP2($id);
    }

    public function store(Request $request)
    {
        $idKgP2 = $request->id_kg_p2;
        if (!$idKgP2) {
            return response()->json([
                'status' => false,
                'message' => 'Parameter id_kg_p2 diperlukan.',
            ], 400);
        }

        DB::beginTransaction();

        try {
            $userId = Auth::id() ?? 'SYSTEM';
            $datap2 = KgP2M::find($idKgP2);
            $idSurvey = $datap2 ? $datap2->id_survey : null;
            $now = now();

            foreach (self::SARPRAS_MAP as $idMaster => $suffix) {
                $uniqueId = substr('424_' . md5($idKgP2 . $idMaster), 0, 25);
                $jenisTrans = $request->input("jenis_transportasi_{$suffix}") ?: '1';
                $gunaTrans = $request->input("penggunaan_transportasi_{$suffix}") ?: '1';
                $kemudahan = $request->input("kemudahan_{$suffix}") ?: '1';

                KgP424M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_akses_sarpras' => $idMaster,
                    ],
                    [
                        'id' => $uniqueId,
                        'id_buat' => $userId,
                        'id_survey' => $idSurvey,
                        'tgl_buat' => $now,
                        'tgl_update' => $now,
                        'jenis_transportasi' => $jenisTrans,
                        'penggunaan_transportasi' => $gunaTrans,
                        'waktu_tempuh' => $request->input("waktu_tempuh_{$suffix}"),
                        'biaya_sekali' => $request->input("biaya_sekali_{$suffix}"),
                        'kemudahan' => $kemudahan,
                    ]
                );
            }

            DB::commit();

            app(SurveyProgressService::class)->syncProgress(
                $idKgP2,
                'P4.24',
                'kg_p424',
                'id_kg_p2'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P424 berhasil disimpan.',
                'data' => ['id_kg_p2' => $idKgP2],
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P424 STORE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->merge(['id_kg_p2' => $request->id_kg_p2 ?? $id]);
        return $this->store($request);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            KgP424M::where('id_kg_p2', $id)->orWhere('id', $id)->delete();

            DB::commit();

            app(SurveyProgressService::class)->recordDelete($id, 'P4.24');

            return response()->json([
                'status' => true,
                'message' => 'Data P424 berhasil dihapus.',
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P424 DELETE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data.',
            ], 500);
        }
    }
}
