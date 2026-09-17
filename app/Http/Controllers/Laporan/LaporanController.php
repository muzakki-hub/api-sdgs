<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use App\Models\Desa\DesaP2;
use App\Models\Individu\P1\IdvP1M;
use App\Models\Keluarga\P2\KgP2M;
use App\Models\RT\P3\RtP3M;
use App\Models\RT\P4\RtP4M;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index()
    {
        $today = Carbon::today()->toDateString();
        $surveyAktif = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();



        if (!$surveyAktif) {
            return view('pages.laporan.laporan', [
                'totalDesa' => DesaP2::count(),
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


        return view('pages.laporan.laporan', [
            'totalDesa' => DesaP2::count(),
            'totalKeluarga' => KgP2M::count(),
            'totalIndividu' => IdvP1M::count(),

            'progressSurvey' => ($surveyAktif ? 1 : 0), // opsional

            'surveyAktif' => $surveyAktif->deskripsi ?? 'Tidak Ada Survey Aktif',
            'mulai' => $surveyAktif->tgl_mulai ?? '-',
            'batas' => $surveyAktif->tgl_akhir ?? '-',
            'statusSurvey' => $surveyAktif ? 'Berjalan' : 'Tidak Aktif'
        ]);
    }
    public function download()
    {
        // Hitungan cepat
        $tipe1           = $this->c('kg_p4', 'tempat_tinggal_yg_ditempati', 1);
        $lainnya        = $this->cIn('kg_p4', 'tempat_tinggal_yg_ditempati', [2, 3, 4, 5, 6]);

        $lahan1         = $this->c('kg_p4', 'status_lahan_tempat_tinggal_yg_ditempati', 1);
        $lahanlainnya   = $this->cIn('kg_p4', 'status_lahan_tempat_tinggal_yg_ditempati', [2, 3, 4]);

        $totalLk        = $this->c('individu_p1', 'jenis_kelamin', 1);
        $totalPr        = $this->c('individu_p1', 'jenis_kelamin', 2);

        $totalAgamaIslam     = $this->c('individu_p1', 'agama', 1);
        $totalAgamaLainnya   = $this->cIn('individu_p1', 'agama', [2, 3, 4, 5, 6]);

        $totalKawin     = $this->c('individu_p1', 'status_pernikahan', 1);
        $totalTidakKawin = $this->c('individu_p1', 'status_pernikahan', 2);
        $totalDudaJanda = $this->c('individu_p1', 'status_pernikahan', 3); // perbaikan

        // --- AGRUPASI DINAMIS (contoh pekerjaan & pendidikan) ---
        $pekerjaan = [];
        foreach (range(1, 16) as $i) {
            $pekerjaan["pekerjaan$i"] = $this->c('individu_p2', 'pekerjaan_utama', $i);
        }

        $pendidikan = [];
        foreach (range(1, 10) as $i) {
            $pendidikan["pendidikan$i"] = $this->c('individu_p5', 'pendidikan_terakhir', $i);
        }

        // Penyandang disabilitas
        $disabilitasKeys = [
            'tunanetra',
            'tunarungu',
            'tunawicara',
            'tunadaksa',
            'tunagrahita',
            'tunalaras',
            'cacat_eks_sakitkusta',
            'cacat_ganda',
            'dipasung'
        ];

        $disabilitas = [];
        foreach ($disabilitasKeys as $key) {
            $disabilitas[$key] = $this->c('individu_p4', $key, 1);
        }

        // Survey
        $today = Carbon::today()->toDateString();
        $surveyAktif = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)->first();



        if (!$surveyAktif) {
            $data = [
                'totalDesa' => 0,
                'totalKeluarga' => 0,
                'totalIndividu' => 0,
                'totalRW' => 0,
                'totalRT' => 0,

                'tempatTinggal1' => 0,
                'tempatTinggalLainnya' => 0,
                'statusLahan1' => 0,
                'statusLahanlainnya' => 0,

                'totalLk' => 0,
                'totalPr' => 0,
                'totalAgamaIslam' => 0,
                'totalAgamaLainnya' => 0,
                'totalKawin' => 0,
                'totalTidakKawin' => 0,
                'totalDudaJanda' => 0,

                'pekerjaan1' => 0,
                'pekerjaan2' => 0,
                'pekerjaan3' => 0,
                'pekerjaan4' => 0,
                'pekerjaan5' => 0,
                'pekerjaan6' => 0,
                'pekerjaan7' => 0,
                'pekerjaan8' => 0,
                'pekerjaan9' => 0,
                'pekerjaan10' => 0,
                'pekerjaan11' => 0,
                'pekerjaan12' => 0,
                'pekerjaan13' => 0,
                'pekerjaan14' => 0,
                'pekerjaan15' => 0,
                'pekerjaan16' => 0,

                'tunanetra' => 0,
                'tunarungu' => 0,
                'tunawicara' => 0,
                'tunadaksa' => 0,
                'tunagrahita' => 0,
                'tunalaras' => 0,
                'cacat_eks_sakitkusta' => 0,
                'cacat_ganda' => 0,
                'dipasung' => 0,

                'pendidikan1' => 0,
                'pendidikan2' => 0,
                'pendidikan3' => 0,
                'pendidikan4' => 0,
                'pendidikan5' => 0,
                'pendidikan6' => 0,
                'pendidikan7' => 0,
                'pendidikan8' => 0,
                'pendidikan9' => 0,
                'pendidikan10' => 0,

                'surveyAktif' => 'Tidak Ada Survey Aktif',
                'mulai'       => '-',
                'batas'       => '-',
                'statusSurvey' => 'Tidak Aktif'
            ];
        } else {
            $mulai = Carbon::parse($surveyAktif->tgl_mulai)->translatedFormat('d F Y');
            $batas = Carbon::parse($surveyAktif->tgl_akhir)->translatedFormat('d F Y');
            // Gabungkan semua
            $data = array_merge([
                'totalDesa' => DesaP2::count(),
                'totalKeluarga' => KgP2M::count(),
                'totalIndividu' => IdvP1M::count(),
                'totalRW' => RtP3M::count(),
                'totalRT' => RtP4M::count(),

                'tempatTinggal1' => $tipe1,
                'tempatTinggalLainnya' => $lainnya,
                'statusLahan1' => $lahan1,
                'statusLahanlainnya' => $lahanlainnya,

                'totalLk' => $totalLk,
                'totalPr' => $totalPr,
                'totalAgamaIslam' => $totalAgamaIslam,
                'totalAgamaLainnya' => $totalAgamaLainnya,
                'totalKawin' => $totalKawin,
                'totalTidakKawin' => $totalTidakKawin,
                'totalDudaJanda' => $totalDudaJanda,

                'surveyAktif' => $surveyAktif->deskripsi ?? 'Tidak Ada Survey Aktif',
                'mulai' => $mulai,
                'batas' => $batas,
                'statusSurvey' => $surveyAktif ? 'Berjalan' : 'Tidak Aktif'
            ], $pekerjaan, $pendidikan, $disabilitas);
        }



        $pdf = Pdf::loadView('pages.laporan.laporan', $data);
        return $pdf->download('laporan-rekap.pdf');
    }

    private function c($table, $column, $value)
    {
        return DB::table($table)->where($column, $value)->count();
    }

    private function cIn($table, $column, array $values)
    {
        return DB::table($table)->whereIn($column, $values)->count();
    }
}
