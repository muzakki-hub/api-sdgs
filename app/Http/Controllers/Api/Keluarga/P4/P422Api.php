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
            $survey = SurveyProgressService::getActiveSurvey();
            $query = KgP422M::where('id_kg_p2', $id);
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $rows = $query->get();

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
        $single = KgP422M::find($id);
        if ($single) {
            return response()->json([
                'status' => true,
                'message' => 'Data P422 ditemukan',
                'data' => $single
            ], 200);
        }

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

        $survey = SurveyProgressService::getActiveSurvey();
        if (!$survey) {
            return response()->json([
                'status' => false,
                'message' => 'Saat ini tidak memasuki periode survei manapun.',
            ], 400);
        }

        $userId = Auth::id() ?? $request->user()?->id ?? '1750902135';

        DB::beginTransaction();

        try {
            $idSurvey = $survey->id;
            $now = now();

            // Single item save from master list
            if ($request->has('id_master_faskes')) {
                $idMaster = $request->id_master_faskes;
                $uniqueId = substr('422_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $kemudahan = $request->input('kemudahan') ?: '1';

                $record = KgP422M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_faskes' => $idMaster,
                        'id_survey' => $idSurvey,
                    ],
                    [
                        'id' => $uniqueId,
                        'id_buat' => $userId,
                        'id_update' => $userId,
                        'id_survey' => $idSurvey,
                        'tgl_buat' => $now,
                        'tgl_update' => $now,
                        'jarak' => $request->input('jarak'),
                        'waktu_tempuh' => $request->input('waktu_tempuh'),
                        'kemudahan' => $kemudahan,
                    ]
                );

                DB::commit();

                app(SurveyProgressService::class)->syncProgress(
                    $idKgP2,
                    'P422',
                    'kg_p422',
                    'id_kg_p2',
                    [],
                    $idSurvey
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Data P422 berhasil disimpan.',
                    'data' => $record,
                ], 200);
            }

            // Bulk save (legacy)
            foreach (self::FASKES_MAP as $idMaster => $key) {
                $uniqueId = substr('422_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $kemudahan = $request->input("kemudahan_{$key}") ?: '1';

                KgP422M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_faskes' => $idMaster,
                        'id_survey' => $idSurvey,
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
                'P422',
                'kg_p422',
                'id_kg_p2',
                [],
                $idSurvey
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
        $record = KgP422M::find($id);
        if ($record) {
            $record->update([
                'jarak' => $request->input('jarak', $record->jarak),
                'waktu_tempuh' => $request->input('waktu_tempuh', $record->waktu_tempuh),
                'kemudahan' => $request->input('kemudahan', $record->kemudahan),
                'id_update' => Auth::id() ?? $request->user()?->id ?? '1750902135',
                'tgl_update' => now(),
            ]);

            $idSurvey = SurveyProgressService::getActiveSurvey()?->id;
            app(SurveyProgressService::class)->syncProgress(
                $record->id_kg_p2,
                'P422',
                'kg_p422',
                'id_kg_p2',
                [],
                $idSurvey
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P422 berhasil diupdate.',
                'data' => $record,
            ], 200);
        }

        $request->merge(['id_kg_p2' => $request->id_kg_p2 ?? $id]);
        return $this->store($request);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $survey = SurveyProgressService::getActiveSurvey();
            $record = KgP422M::find($id);
            $idKgP2 = $record ? $record->id_kg_p2 : $id;

            if ($record) {
                $record->delete();
            } else {
                $query = KgP422M::where('id_kg_p2', $id);
                if ($survey) {
                    $query->where('id_survey', $survey->id);
                }
                $query->delete();
            }

            DB::commit();

            app(SurveyProgressService::class)->syncProgress($idKgP2, 'P422', 'kg_p422', 'id_kg_p2', [], $survey?->id);

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
