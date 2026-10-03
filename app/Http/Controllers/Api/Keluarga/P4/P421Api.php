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
            $survey = SurveyProgressService::getActiveSurvey();
            $query = KgP421M::where('id_kg_p2', $id);
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $rows = $query->get();

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
        $single = KgP421M::find($id);
        if ($single) {
            return response()->json([
                'status' => true,
                'message' => 'Data P421 ditemukan',
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
            if ($request->has('id_master_pendidikan')) {
                $idMaster = $request->id_master_pendidikan;
                $uniqueId = substr('421_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $kemudahan = $request->input('kemudahan') ?: '1';

                $record = KgP421M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_pendidikan' => $idMaster,
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
                    'P421',
                    'kg_p421',
                    'id_kg_p2',
                    [],
                    $idSurvey
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Data P421 berhasil disimpan.',
                    'data' => $record,
                ], 200);
            }

            // Bulk save (legacy)
            foreach (self::PENDIDIKAN_MAP as $idMaster => $key) {
                $uniqueId = substr('421_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $kemudahan = $request->input("kemudahan_{$key}") ?: '1';

                KgP421M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_pendidikan' => $idMaster,
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
                'P421',
                'kg_p421',
                'id_kg_p2',
                [],
                $idSurvey
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
        $record = KgP421M::find($id);
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
                'P421',
                'kg_p421',
                'id_kg_p2',
                [],
                $idSurvey
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P421 berhasil diupdate.',
                'data' => $record,
            ], 200);
        }

        // Passthrough to store (upsert behavior)
        $request->merge(['id_kg_p2' => $request->id_kg_p2 ?? $id]);
        return $this->store($request);
    }

    public function destroy($id)
    {
        DB::beginTransaction();

        try {
            $survey = SurveyProgressService::getActiveSurvey();
            $record = KgP421M::find($id);
            $idKgP2 = $record ? $record->id_kg_p2 : $id;

            if ($record) {
                $record->delete();
            } else {
                $query = KgP421M::where('id_kg_p2', $id);
                if ($survey) {
                    $query->where('id_survey', $survey->id);
                }
                $query->delete();
            }

            DB::commit();

            app(SurveyProgressService::class)->syncProgress($idKgP2, 'P421', 'kg_p421', 'id_kg_p2', [], $survey?->id);

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
