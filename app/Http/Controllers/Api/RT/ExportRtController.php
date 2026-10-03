<?php

namespace App\Http\Controllers\Api\RT;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Models\Master\MasterKlbRTM;
use App\Http\Controllers\Controller;
use App\Models\Master\MasterTvRadioRTM;
use App\Models\RT\P9\TransaksiKlbP9RTM;
use App\Models\Master\MasterKejahatanRTM;
use App\Models\Master\MasterKesehatanRTM;
use App\Models\Master\MasterGunaSumberRTM;
use App\Models\Master\MasterLingkunganRTM;
use App\Models\Master\MasterPendidikanRTM;
use App\Models\Master\MasterBencanaAlamRTM;
use App\Models\Master\MasterPerkelahianRTM;
use App\Models\RT\P6\TransaksiTvRadioP6RTM;
use App\Models\RT\P5\TransaksiIndustriP5RTM;
use App\Models\Master\MasterJenisIndustriRTM;
use App\Models\Master\MasterSaranaEkonomiRTM;
use App\Models\RT\P9\TransaksiKesehatanP9RTM;
use App\Models\Master\MasterOperatorSinyalRTM;
use App\Models\RT\P7\TransaksiGunaSumberP7RTM;
use App\Models\RT\P7\TransaksiPencemaranP7RTM;
use App\Models\RT\P11\TransaksiKejahatanP11RTM;
use App\Models\RT\P7\TransaksiBencanaAlamP7RTM;
use App\Models\Master\MasterLembagaMasyarakatRTM;
use App\Models\RT\P11\TransaksiPerkelahianP11RTM;
use App\Models\RT\P5\TransaksiSaranaEkonomiP5RTM;
use App\Models\RT\P6\TransaksiOperatorSinyalP6RTM;
use App\Models\RT\P10\TransaksiLembagaMasyarakatP10RTM;
use App\Services\SurveyProgressService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;

class ExportRtController extends Controller
{
    public function export($idP4, $idP3 = null)
    {
        $p4 = DB::table('rt_p4')->where('id', $idP4)->first();
        if (!$p4) {
            return response()->json([
                'status' => false,
                'message' => 'Data RT tidak ditemukan',
            ], 404);
        }

        if (!$idP3) {
            $idP3 = $p4->id_p3_rw;
        }

        $activeSurvey = SurveyProgressService::getActiveSurvey();
        $idSurvey = $activeSurvey?->id;

        // Query helper untuk single-row table dengan prioritas survey aktif
        $getSingleRecord = function ($table, $idCol = 'id_p4', $idVal = null) use ($idP4, $idSurvey) {
            $idVal = $idVal ?? $idP4;
            $query = DB::table($table)->where($idCol, $idVal);
            if ($idSurvey && Schema::hasColumn($table, 'id_survey')) {
                $record = (clone $query)->where('id_survey', $idSurvey)
                    ->when(Schema::hasColumn($table, 'tgl_buat'), fn($q) => $q->orderByDesc('tgl_buat'))
                    ->first();
                if ($record) {
                    return $record;
                }
            }
            return $query
                ->when(Schema::hasColumn($table, 'tgl_buat'), fn($q) => $q->orderByDesc('tgl_buat'))
                ->first();
        };

        // Query helper untuk multi-row table dengan prioritas survey aktif
        $getMultiRecord = function ($modelOrTable, $idCol = 'id_p4', $idVal = null) use ($idP4, $idSurvey) {
            $idVal = $idVal ?? $idP4;
            $isModel = is_string($modelOrTable) && class_exists($modelOrTable);
            $query = $isModel ? $modelOrTable::where($idCol, $idVal) : DB::table($modelOrTable)->where($idCol, $idVal);
            $table = $isModel ? (new $modelOrTable())->getTable() : $modelOrTable;
            if ($idSurvey && Schema::hasColumn($table, 'id_survey')) {
                $records = (clone $query)->where('id_survey', $idSurvey)->get();
                if ($records->isNotEmpty()) {
                    return $records;
                }
            }
            return $query->get();
        };

        // P2 query dengan prioritas survey aktif
        $p2Query = DB::table("rt_p2")
            ->leftJoin("rt_p4", "rt_p2.id_p4", "=", "rt_p4.id")
            ->leftJoin("rt_p3", "rt_p4.id_p3_rw", "=", "rt_p3.id")
            ->where("rt_p2.id_p4", $idP4)
            ->select(
                "rt_p2.*",
                "rt_p4.rt as rt",
                "rt_p3.nama_rw as rw"
            );

        $p2 = null;
        if ($idSurvey) {
            $p2 = (clone $p2Query)->where("rt_p2.id_survey", $idSurvey)->orderByDesc("rt_p2.tgl_buat")->first();
        }
        if (!$p2) {
            $p2 = $p2Query->orderByDesc("rt_p2.tgl_buat")->first();
        }

        // P3 query
        $p3 = DB::table('rt_p3 as p3')
            ->leftJoin('wilayah as prov', 'p3.kode_provinsi', '=', 'prov.kode')
            ->leftJoin('wilayah as kab', 'p3.kode_kabupaten', '=', 'kab.kode')
            ->leftJoin('wilayah as kec', 'p3.kode_kecamatan', '=', 'kec.kode')
            ->leftJoin('wilayah as desa', 'p3.kode_desa', '=', 'desa.kode')
            ->where('p3.id', $idP3)
            ->select(
                'p3.*',
                'prov.nama as nama_provinsi',
                'kab.nama as nama_kabupaten',
                'kec.nama as nama_kecamatan',
                'desa.nama as nama_desa'
            )
            ->first();

        // Cari foto ketua RW
        $fotoRw = null;
        if ($p3 && isset($p3->id)) {
            $rwPattern = public_path('uploads/rt_p3/foto_ket_rw_' . $p3->id . '.*');
            $rwFiles = glob($rwPattern);
            if (!empty($rwFiles)) {
                $fotoRw = $rwFiles[0];
            }
        }

        // Cari foto ketua RT
        $fotoRt = null;
        if ($p4 && isset($p4->id)) {
            $rtPattern = public_path('uploads/rt_p4/foto_ket_rt_' . $p4->id . '.*');
            $rtFiles = glob($rtPattern);
            if (!empty($rtFiles)) {
                $fotoRt = $rtFiles[0];
            }
        }

        // Enumerator (auth user login, atau pembuat kuesioner, atau fallback ke user sistem)
        $userEnumerator = \App\Services\CoverDataService::getEnumeratorUser($p4 ?? $p2, request());

        // P801 (Pendidikan)
        $p801Query = DB::table('transaksi_pendidikan_p8_rt')->join(
            'master_pendidikan_rt',
            'transaksi_pendidikan_p8_rt.id_master_pendidikan',
            '=',
            'master_pendidikan_rt.id'
        )->where('transaksi_pendidikan_p8_rt.id_p4', $idP4);

        if ($idSurvey) {
            $p801 = (clone $p801Query)->where('transaksi_pendidikan_p8_rt.id_survey', $idSurvey)->get();
            if ($p801->isEmpty()) {
                $p801 = $p801Query->get();
            }
        } else {
            $p801 = $p801Query->get();
        }

        $data = [
            'user' => $userEnumerator,
            'foto_rw' => $fotoRw,
            'foto_rt' => $fotoRt,
            'p2' => $p2,
            'p3' => $p3,
            'p4' => $p4,
            'p5' => $getSingleRecord('rt_p5'),
            'p6' => $getSingleRecord('rt_p6'),
            'p7' => $getSingleRecord('rt_p7'),
            'p8' => $getSingleRecord('rt_p8'),
            'p10' => $getSingleRecord('rt_p10'),
            'p11' => $getSingleRecord('rt_p11'),

            'master_p502' => MasterJenisIndustriRTM::select('id', 'jenis_industri')->get(),
            'p502' => $getMultiRecord(TransaksiIndustriP5RTM::class),

            'master_p508' => MasterSaranaEkonomiRTM::select('id', 'sarana_ekonomi')->get(),
            'p508' => $getMultiRecord(TransaksiSaranaEkonomiP5RTM::class),

            'master_p607' => MasterOperatorSinyalRTM::select('id', 'nama_operator')->get(),
            'p607' => $getMultiRecord(TransaksiOperatorSinyalP6RTM::class),

            'master_p609' => MasterTvRadioRTM::select('id', 'program_tv_radio')->get(),
            'p609' => $getMultiRecord(TransaksiTvRadioP6RTM::class),

            'master_p706' => MasterGunaSumberRTM::select('id', 'jenis_penggunaan')->get(),
            'p706' => $getMultiRecord(TransaksiGunaSumberP7RTM::class),

            'master_p709' => MasterLingkunganRTM::select('id', 'jenis_lingkungan')->get(),
            'p709' => $getMultiRecord(TransaksiPencemaranP7RTM::class),

            'master_p713' => MasterBencanaAlamRTM::select('id', 'jenis_bencana')->get(),
            'p713' => $getMultiRecord(TransaksiBencanaAlamP7RTM::class),

            'master_p801' => MasterPendidikanRTM::select('id', 'jenjang_pendidikan')->get(),
            'p801' => $p801,

            'master_p901' => MasterKesehatanRTM::select('id', 'jenjang_kesehatan')->get(),
            'p901' => $getMultiRecord(TransaksiKesehatanP9RTM::class),

            'master_p902' => MasterKlbRTM::select('id', 'jenis_klb')->get(),
            'p902' => $getMultiRecord(TransaksiKlbP9RTM::class),

            'p1004' => $getMultiRecord('rt_p1004'),

            'master_p1009' => MasterLembagaMasyarakatRTM::select('id', 'nama_lembaga')->get(),
            'p1009' => $getMultiRecord(TransaksiLembagaMasyarakatP10RTM::class),

            'p11' => $getSingleRecord('rt_p11'),

            'master_p1101' => MasterPerkelahianRTM::select('id', 'jenis_perkelahian')->get(),
            'p1101' => $getMultiRecord(TransaksiPerkelahianP11RTM::class),

            'master_p1102' => MasterKejahatanRTM::select('id', 'jenis_kejahatan')->get(),
            'p1102' => $getMultiRecord(TransaksiKejahatanP11RTM::class),
        ];

        $rtNumber = isset($p4->rt) ? str_pad($p4->rt, 2, '0', STR_PAD_LEFT) : 'data';
        $filename = "formulir_rt_{$rtNumber}.pdf";

        $enumerator = \App\Services\CoverDataService::resolveEnumerator($p4 ?? $p2, request());
        $wilayah = \App\Services\CoverDataService::resolveWilayah();

        $cover = [
            'level' => 'rt',
            'header_img' => \App\Services\CoverDataService::getHeaderImageBase64(),
            'rt' => $p4->rt ?? '-',
            'rw' => $p3->nama_rw ?? '-',
            'dusun' => $p3->nama_dusun ?? $p4->alamat_ket_rt ?? '-',
            'desa' => $p3->nama_desa ?? $wilayah['desa'],
            'enumerator_nama' => $enumerator['nama'],
            'enumerator_jabatan' => $enumerator['jabatan'],
            'enumerator_ttd' => $enumerator['ttd'] ?? '',
        ];

        $pdf = Pdf::loadView('pages.rt.export', [
            'cover' => $cover,
            'data' => $data,
            'user' => $userEnumerator,
            'foto_rw' => $fotoRw,
            'foto_rt' => $fotoRt,
        ]);

        if (request()->has('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}
