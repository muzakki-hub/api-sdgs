<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP421M;
use App\Models\Keluarga\P2\KgP2M;
use App\Services\SurveyProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P421Api extends Controller
{
    public const PENDIDIKAN_MAP = [
        'P001' => 'paud',
        'P002' => 'tk',
        'P003' => 'sd',
        'P004' => 'smp',
        'P005' => 'sma',
        'P006' => 'pt',
        'P007' => 'pesantren',
        'P008' => 'seminari',
        'P009' => 'keagamaan',
    ];

    public function showByIdP2($id)
    {
        try {
            $rows = KgP421M::where('id_kg_p2', $id)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P421 belum ada',
                    'data' => null,
                ], 404);
            }

            $flat = [
                'id' => $id,
                'id_kg_p2' => $id,
            ];

            foreach ($rows as $row) {
                $key = self::PENDIDIKAN_MAP[$row->id_master_pendidikan] ?? null;
                if ($key) {
                    $flat["jarak_{$key}"] = $row->jarak;
                    $flat["waktu_{$key}"] = $row->waktu_tempuh;
                    $flat["kemudahan_{$key}"] = $row->kemudahan;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data P421 ditemukan',
                'data' => $flat,
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P421 SHOW] " . $e->getMessage());
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

            foreach (self::PENDIDIKAN_MAP as $idMaster => $key) {
                $uniqueId = substr('421_' . md5($idKgP2 . $idMaster), 0, 25);
                $kemudahan = $request->input("kemudahan_{$key}") ?: '1';

                KgP421M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_pendidikan' => $idMaster,
                    ],
                    [
                        'id' => $uniqueId,
                        'id_buat' => $userId,
                        'id_survey' => $idSurvey,
                        'tgl_buat' => $now,
                        'tgl_update' => $now,
                        'jarak' => $request->input("jarak_{$key}"),
                        'waktu_tempuh' => $request->input("waktu_{$key}"),
                        'kemudahan' => $kemudahan,
                    ]
                );
            }

            DB::commit();

            app(SurveyProgressService::class)->syncProgress(
                $idKgP2,
                'P4.21',
                'kg_p421',
                'id_kg_p2'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P421 berhasil disimpan.',
                'data' => ['id_kg_p2' => $idKgP2],
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P421 STORE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data: ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        // Passthrough to store (upsert behavior)
        $request->merge(['id_kg_p2' => $request->id_kg_p2 ?? $id]);
        return $this->store($request);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            KgP421M::where('id_kg_p2', $id)->orWhere('id', $id)->delete();

            DB::commit();

            app(SurveyProgressService::class)->recordDelete($id, 'P4.21');

            return response()->json([
                'status' => true,
                'message' => 'Data P421 berhasil dihapus.',
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P421 DELETE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data.',
            ], 500);
        }
    }
}
