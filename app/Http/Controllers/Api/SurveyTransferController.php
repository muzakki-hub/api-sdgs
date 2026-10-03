<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SurveyCopyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurveyTransferController extends Controller
{
    protected SurveyCopyService $copyService;

    public function __construct(SurveyCopyService $copyService)
    {
        $this->copyService = $copyService;
    }

    public function tarikDataSebelumnyaRt(Request $request, $idP4)
    {
        $userId = Auth::id() ?? $request->user()?->id;
        $result = $this->copyService->copyRtData($idP4, $userId);

        $statusCode = ($result['status'] ?? false) ? 200 : 400;
        return response()->json($result, $statusCode);
    }

    public function tarikDataSebelumnyaKg(Request $request, $idP2)
    {
        $userId = Auth::id() ?? $request->user()?->id;
        $result = $this->copyService->copyKeluargaData($idP2, $userId);

        $statusCode = ($result['status'] ?? false) ? 200 : 400;
        return response()->json($result, $statusCode);
    }

    public function tarikDataSebelumnyaIdv(Request $request, $idP1)
    {
        $userId = Auth::id() ?? $request->user()?->id;
        $result = $this->copyService->copyIndividuData($idP1, $userId);

        $statusCode = ($result['status'] ?? false) ? 200 : 400;
        return response()->json($result, $statusCode);
    }

    public function getWilayahOptions(Request $request)
    {
        $level = strtolower($request->query('level', 'rt'));

        if ($level === 'individu' || $level === 'idv') {
            $activeSurvey = \App\Services\SurveyProgressService::getActiveSurvey();
            $prevSurvey = \App\Services\SurveyCopyService::getPreviousSurvey($activeSurvey);

            $queryActive = \Illuminate\Support\Facades\DB::table('individu_p1')
                ->select('id', 'nama', 'nik');
            if ($activeSurvey) {
                $queryActive->where('id_survey', $activeSurvey->id);
            }
            $individuals = $queryActive->orderBy('nama', 'asc')->get();

            if ($individuals->isEmpty() && $prevSurvey) {
                $individuals = \Illuminate\Support\Facades\DB::table('individu_p1')
                    ->select('id', 'nama', 'nik')
                    ->where('id_survey', $prevSurvey->id)
                    ->orderBy('nama', 'asc')
                    ->get();
            }

            if ($individuals->isEmpty()) {
                $individuals = \Illuminate\Support\Facades\DB::table('individu_p1')
                    ->select('id', 'nama', 'nik')
                    ->orderBy('nama', 'asc')
                    ->get();
            }

            $targets = $individuals->map(fn($ind) => [
                'id' => $ind->id,
                'label' => ($ind->nama ?? 'Tanpa Nama') . ' (' . ($ind->nik ?? '-') . ')',
            ])->values();

            $groups = [];
            if ($targets->isNotEmpty()) {
                $groups[] = [
                    'id' => 'all',
                    'label' => 'Seluruh Individu (' . $targets->count() . ' Orang)',
                    'targets' => $targets,
                ];
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'level' => 'individu',
                    'totalTarget' => $targets->count(),
                    'groups' => $groups,
                ]
            ]);
        }

        if ($level === 'keluarga' || $level === 'kg') {
            $activeSurvey = \App\Services\SurveyProgressService::getActiveSurvey();
            $prevSurvey = \App\Services\SurveyCopyService::getPreviousSurvey($activeSurvey);

            // 1. Prioritaskan keluarga yang sudah ada di survei aktif
            $queryActive = \Illuminate\Support\Facades\DB::table('kg_p2')
                ->select('id', 'nama_kpl_keluarga', 'no_kk');
            if ($activeSurvey) {
                $queryActive->where('id_survey', $activeSurvey->id);
            }
            $families = $queryActive->orderBy('nama_kpl_keluarga', 'asc')->get();

            // 2. Jika survei aktif belum memiliki data keluarga, ambil keluarga dari survei sebelumnya
            if ($families->isEmpty() && $prevSurvey) {
                $families = \Illuminate\Support\Facades\DB::table('kg_p2')
                    ->select('id', 'nama_kpl_keluarga', 'no_kk')
                    ->where('id_survey', $prevSurvey->id)
                    ->orderBy('nama_kpl_keluarga', 'asc')
                    ->get();
            }

            // 3. Fallback jika masih kosong (ambil semua)
            if ($families->isEmpty()) {
                $families = \Illuminate\Support\Facades\DB::table('kg_p2')
                    ->select('id', 'nama_kpl_keluarga', 'no_kk')
                    ->orderBy('nama_kpl_keluarga', 'asc')
                    ->get();
            }

            $targets = $families->map(fn($f) => [
                'id' => $f->id,
                'label' => 'KK ' . ($f->nama_kpl_keluarga ?? $f->no_kk),
            ])->values();

            $groups = [];
            if ($targets->isNotEmpty()) {
                $groups[] = [
                    'id' => 'all',
                    'label' => 'Seluruh Keluarga (' . $targets->count() . ' KK)',
                    'targets' => $targets,
                ];
            }

            return response()->json([
                'status' => true,
                'data' => [
                    'level' => 'keluarga',
                    'totalTarget' => $targets->count(),
                    'groups' => $groups,
                ]
            ]);
        }

        // Default: Level RT
        $rws = \Illuminate\Support\Facades\DB::table('rt_p3')
            ->select('id', 'nama_rw')
            ->orderBy('nama_rw', 'asc')
            ->get()
            ->keyBy('id');
        $rts = \Illuminate\Support\Facades\DB::table('rt_p4')
            ->select('id', 'rt', 'id_p3_rw', 'nama_ket_rt')
            ->orderBy('rt', 'asc')
            ->get();

        $allRtTargets = $rts->map(function ($r) use ($rws) {
            $rwName = isset($rws[$r->id_p3_rw]) ? $rws[$r->id_p3_rw]->nama_rw : null;
            return [
                'id' => $r->id,
                'label' => 'RT ' . $r->rt,
                'id_p3_rw' => $r->id_p3_rw,
                'rw_label' => $rwName ? 'RW ' . $rwName : 'Wilayah Lainnya',
            ];
        })->values();

        $groups = [];
        if ($allRtTargets->isNotEmpty()) {
            $groups[] = [
                'id' => 'all',
                'label' => 'Seluruh Wilayah (' . $allRtTargets->count() . ' RT)',
                'targets' => $allRtTargets,
            ];
        }

        foreach ($rws as $rw) {
            $rwRts = $allRtTargets->where('id_p3_rw', $rw->id)->values();
            if ($rwRts->isNotEmpty()) {
                $groups[] = [
                    'id' => $rw->id,
                    'label' => 'RW ' . $rw->nama_rw . ' (' . $rwRts->count() . ' RT)',
                    'targets' => $rwRts,
                ];
            }
        }

        return response()->json([
            'status' => true,
            'data' => [
                'level' => 'rt',
                'totalTarget' => $allRtTargets->count(),
                'groups' => $groups,
            ]
        ]);
    }
}
