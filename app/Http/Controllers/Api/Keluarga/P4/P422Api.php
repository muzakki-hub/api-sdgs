<?php

namespace App\Http\Controllers\Api\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P4\KgP422M;
use App\Models\Keluarga\P2\KgP2M;
use App\Services\SurveyProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P422Api extends Controller
{
    public const FASKES_MAP = [
        'F001' => 'rs',
        'F002' => 'bersalin',
        'F003' => 'poliklinik',
        'F004' => 'puskesmas',
        'F005' => 'pustu',
        'F006' => 'polindes',
        'F007' => 'poskesdes',
        'F008' => 'posyandu',
        'F009' => 'apotik',
        'F010' => 'toko_obat',
    ];

    public function showByIdP2($id)
    {
        try {
            $rows = KgP422M::where('id_kg_p2', $id)->get();

            if ($rows->isEmpty()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data P422 belum ada',
                    'data' => null,
                ], 404);
            }

            $flat = [
                'id' => $id,
                'id_kg_p2' => $id,
            ];

            foreach ($rows as $row) {
                $key = self::FASKES_MAP[$row->id_master_faskes] ?? null;
                if ($key) {
                    $flat["jarak_{$key}"] = $row->jarak;
                    $flat["waktu_{$key}"] = $row->waktu_tempuh;
                    $flat["kemudahan_{$key}"] = $row->kemudahan;
                }
            }

            return response()->json([
                'status' => true,
                'message' => 'Data P422 ditemukan',
                'data' => $flat,
            ], 200);
        } catch (\Throwable $e) {
            Log::error("[P422 SHOW] " . $e->getMessage());
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

            foreach (self::FASKES_MAP as $idMaster => $key) {
                $uniqueId = substr('422_' . md5($idKgP2 . $idMaster), 0, 25);
                $kemudahan = $request->input("kemudahan_{$key}") ?: '1';

                KgP422M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_faskes' => $idMaster,
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
                'P4.22',
                'kg_p422',
                'id_kg_p2'
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P422 berhasil disimpan.',
                'data' => ['id_kg_p2' => $idKgP2],
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P422 STORE] " . $e->getMessage());

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
            KgP422M::where('id_kg_p2', $id)->orWhere('id', $id)->delete();

            DB::commit();

            app(SurveyProgressService::class)->recordDelete($id, 'P4.22');

            return response()->json([
                'status' => true,
                'message' => 'Data P422 berhasil dihapus.',
            ], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("[P422 DELETE] " . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus data.',
            ], 500);
        }
    }
}
