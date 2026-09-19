<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SurveyProgressService;
use Illuminate\Http\Request;

class DashboardApiController extends Controller
{
    protected SurveyProgressService $progressService;

    public function __construct(SurveyProgressService $progressService)
    {
        $this->progressService = $progressService;
    }

    /**
     * Mengambil statistik pendataan untuk dashboard berdasarkan level aktif.
     * Query param: ?level=rt (default) atau ?level=keluarga
     */
    public function getStats(Request $request)
    {
        try {
            $level = $request->query('level', 'rt');
            $stats = $this->progressService->getLevelDashboardStats($level);

            return response()->json([
                'status' => true,
                'message' => 'Dashboard statistics retrieved successfully',
                'data' => $stats,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil statistik dashboard: ' . $th->getMessage(),
            ], 500);
        }
    }
}
