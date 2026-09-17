<?php

namespace App\Http\Controllers\Api\Survey;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyApi extends Controller
{
    public function index()
    {
        $data = Survey::all();
        // return view('pages.desa.survey', compact('survey'));
        return response()->json($data);
    }

    public function getSurveyAktif()
    {
        $today = date('Y-m-d');

        $survey = \App\Models\Survey\Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if ($survey) {
            return response()->json([
                'success' => true,
                'data' => $survey
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada survey aktif untuk tanggal hari ini'
            ]);
        }
    }
}
