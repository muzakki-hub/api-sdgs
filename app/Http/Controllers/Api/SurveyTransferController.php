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
}
