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
            $survey = SurveyProgressService::getActiveSurvey();
            $query = KgP424M::where('id_kg_p2', $id);
            if ($survey) {
                $query->where('id_survey', $survey->id);
            }
            $rows = $query->get();

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
        $single = KgP424M::find($id);
        if ($single) {
            return response()->json([
                'status' => true,
                'message' => 'Data P424 ditemukan',
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
            if ($request->has('id_master_akses_sarpras')) {
                $idMaster = $request->id_master_akses_sarpras;
                $uniqueId = substr('424_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $kemudahan = $request->input('kemudahan') ?: '1';
                $jenisTrans = $request->input('jenis_transportasi') ?: '1';
                $gunaTrans = $request->input('penggunaan_transportasi') ?: '1';

                $record = KgP424M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_akses_sarpras' => $idMaster,
                        'id_survey' => $idSurvey,
                    ],
                    [
                        'id' => $uniqueId,
                        'id_buat' => $userId,
                        'id_update' => $userId,
                        'id_survey' => $idSurvey,
                        'tgl_buat' => $now,
                        'tgl_update' => $now,
                        'jenis_transportasi' => $jenisTrans,
                        'penggunaan_transportasi' => $gunaTrans,
                        'waktu_tempuh' => $request->input('waktu_tempuh'),
                        'biaya_sekali' => $request->input('biaya_sekali'),
                        'kemudahan' => $kemudahan,
                    ]
                );

                DB::commit();

                app(SurveyProgressService::class)->syncProgress(
                    $idKgP2,
                    'P424',
                    'kg_p424',
                    'id_kg_p2',
                    [],
                    $idSurvey
                );

                return response()->json([
                    'status' => true,
                    'message' => 'Data P424 berhasil disimpan.',
                    'data' => $record,
                ], 200);
            }

            // Bulk save (legacy)
            foreach (self::SARPRAS_MAP as $idMaster => $suffix) {
                $uniqueId = substr('424_' . md5($idKgP2 . $idMaster . $idSurvey), 0, 25);
                $jenisTrans = $request->input("jenis_transportasi_{$suffix}") ?: '1';
                $gunaTrans = $request->input("penggunaan_transportasi_{$suffix}") ?: '1';
                $kemudahan = $request->input("kemudahan_{$suffix}") ?: '1';

                KgP424M::updateOrCreate(
                    [
                        'id_kg_p2' => $idKgP2,
                        'id_master_akses_sarpras' => $idMaster,
                        'id_survey' => $idSurvey,
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
                'P424',
                'kg_p424',
                'id_kg_p2',
                [],
                $idSurvey
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
        $record = KgP424M::find($id);
        if ($record) {
            $record->update([
                'jenis_transportasi' => $request->input('jenis_transportasi', $record->jenis_transportasi),
                'penggunaan_transportasi' => $request->input('penggunaan_transportasi', $record->penggunaan_transportasi),
                'waktu_tempuh' => $request->input('waktu_tempuh', $record->waktu_tempuh),
                'biaya_sekali' => $request->input('biaya_sekali', $record->biaya_sekali),
                'kemudahan' => $request->input('kemudahan', $record->kemudahan),
                'id_update' => Auth::id() ?? $request->user()?->id ?? '1750902135',
                'tgl_update' => now(),
            ]);

            $idSurvey = SurveyProgressService::getActiveSurvey()?->id;
            app(SurveyProgressService::class)->syncProgress(
                $record->id_kg_p2,
                'P424',
                'kg_p424',
                'id_kg_p2',
                [],
                $idSurvey
            );

            return response()->json([
                'status' => true,
                'message' => 'Data P424 berhasil diupdate.',
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
            $record = KgP424M::find($id);
            $idKgP2 = $record ? $record->id_kg_p2 : $id;

            if ($record) {
                $record->delete();
            } else {
                $query = KgP424M::where('id_kg_p2', $id);
                if ($survey) {
                    $query->where('id_survey', $survey->id);
                }
                $query->delete();
            }

            DB::commit();

            app(SurveyProgressService::class)->syncProgress($idKgP2, 'P424', 'kg_p424', 'id_kg_p2', [], $survey?->id);

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
