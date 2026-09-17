<?php

namespace App\Http\Controllers;

use App\Models\Desa\DesaP2;
use App\Models\Desa\P10\P10;
use App\Models\Desa\P3\AnggotaBpd;
use App\Models\Desa\P3\P3;
use App\Models\Desa\P3\PegawaiLainnya;
use App\Models\Desa\P4\P4;
use App\Models\Desa\P5\P5;
use App\Models\Desa\P5\P501;
use App\Models\Desa\P5\P502;
use App\Models\Desa\P5\P503;
use App\Models\Desa\P6\P601;
use App\Models\Desa\P6\P602;
use App\Models\Desa\P6\P603;
use App\Models\Desa\P7\P7;
use App\Models\Desa\P7\P705;
use App\Models\Desa\P8\P8;
use App\Models\Desa\P9\P9;
use App\Models\Desa\P9\P914;
use App\Models\Desa\P9\P923;
use App\Models\Desa\P9\P932;
use App\Models\Desa\P9\P941;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Keluarga\P2\KgP2M;
use App\Models\Skor\Desa\SkorDesaP2;
use Illuminate\Http\Request;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // survey aktif hari ini
        $today = Carbon::today()->toDateString();
        $surveyAktif = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();
		$desaAktif = $surveyAktif
            ? DesaP2::with('survey')->where('id_survey', $surveyAktif->id)->get()
            : collect();
        if (!$surveyAktif) {
            return view('pages.dashboard', [
                'totalDesa' => $desaAktif,
                'totalKeluarga' => KgP2M::count(),
                'totalIndividu' => IdvP1M::count(),

                'progressSurvey' => 0,
                'progressP' => array_fill(0, 9, 0), // semua progress 0
                'surveyAktif' => 'Tidak Ada Survey Aktif',
                'mulai' => '-',
                'batas' => '-',
                'statusSurvey' => 'Tidak Aktif',
            ]);
        }

        $skorp2 = SkorDesaP2::first();
        $totalP2 = collect($skorp2)->sum();

        $skorp3 = DB::table('skor_desa_p3')->first();
        $totalP3 = collect($skorp3)->sum();

        $p4 = P4::where('id_survey', $surveyAktif->id)->exists();
        $totalP4 = $p4 ? 100 : 0;

        // SKOR P5 (dari view)
        $skorp5 = DB::table('skor_desa_p5')->first();
        $totalP5 = collect($skorp5)->sum();

        // SKOR P501
        $p501 = P501::where('id_survey', $surveyAktif->id)->exists();
        $totalP501 = $p501 ? 20 : 0;

        // SKOR P502
        $p502 = P502::where('id_survey', $surveyAktif->id)->exists();
        $totalP502 = $p502 ? 20 : 0;

        // SKOR P503
        $p503 = P503::where('id_survey', $surveyAktif->id)->exists();
        $totalP503 = $p503 ? 20 : 0;

        // Total keseluruhan P5 = view + sub table
        $totalP5Final = $totalP5 + $totalP501 + $totalP502 + $totalP503;

        $skorp601 = DB::table('skor_desa_p601')->first();
        $totalP601 = $skorp601 ? collect($skorp601)->sum() : 0;

        $skorp602 = DB::table('skor_desa_p602')->first();
        $totalP602 = $skorp602 ? collect($skorp602)->sum() : 0;

        $p603 = P603::where('id_survey', $surveyAktif->id)->exists();
        $totalP603 = $p603 ? 10 : 0;

        $totalP6Final = $totalP601 + $totalP602 + $totalP603;

        $skorp7 = DB::table('skor_desa_p7')->first();
        $totalP7 = $skorp7 ? collect($skorp7)->sum() : 0;

        $p705 = P705::where('id_survey', $surveyAktif->id)->exists();
        $totalP705 = $p705 ? 20 : 0;

        $totalFinalP7 = $totalP7 + $totalP705;

        $p8 = P8::where('id_survey', $surveyAktif->id)->exists();
        $totalP8 = $p8 ? 100 : 0;

        $p9 = P9::where('id_survey', $surveyAktif->id)->exists();
        $totalP9 = $p9 ? 100 : 0;

        $p10 = P10::where('id_survey', $surveyAktif->id)->exists();
        $totalP10 = $p10 ? 100 : 0;


        // progress P2–P10 berdasarkan jumlah data
        $progressP = [
            $totalP2,
            $totalP3,
            $totalP4,
            $totalP5Final,
            $totalP6Final,
            $totalFinalP7,
            $totalP8,
            $totalP9,
            $totalP10,
        ];
		

        return view('pages.dashboard', [
            'totalDesa' => $desaAktif,
            'totalKeluarga' => KgP2M::count(),
            'totalIndividu' => IdvP1M::count(),

            'progressSurvey' => ($surveyAktif ? 1 : 0), // opsional
            'progressP' => $progressP,
            // 'kategoriP2' => $kategoriP2,

            'surveyAktif' => $surveyAktif->deskripsi ?? 'Tidak Ada Survey Aktif',
            'mulai' => $surveyAktif->tgl_mulai ?? '-',
            'batas' => $surveyAktif->tgl_akhir ?? '-',
            'statusSurvey' => $surveyAktif ? 'Berjalan' : 'Tidak Aktif'
        ]);
    }
}
