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

// use Illuminate\Http\Request;

// use App\Models\Rt\RtP3;
// use App\Models\Rt\RtP4;
// use App\Models\Rt\RtP5;
// use App\Models\Rt\RtP6;
// use App\Models\Rt\RtP7;
// use App\Models\Rt\RtP8;
// use App\Models\Rt\MasterTvRadio;
// use App\Models\Rt\MasterKesehatan;
// use App\Models\Rt\MasterGunaSumber;
// use App\Models\Rt\MasterLingkungan;
// use App\Models\Rt\MasterPendidikan;
// use App\Models\Rt\MasterBencanaAlam;
// use App\Models\Rt\MasterJenisIndustri;
// use App\Models\Rt\MasterSaranaEkonomi;
// use App\Models\Rt\MasterOperatorSinyal;
// use App\Models\Rt\TransaksiTvRadioP6Rt;
// use App\Models\Rt\TransaksiIndustriP5Rt;
// use App\Models\Rt\TransaksiKesehatanP9Rt;
// use App\Models\Rt\TransaksiGunaSumberP7Rt;
// use App\Models\Rt\TransaksiPencemaranP7Rt;
// use App\Models\Rt\TransaksiBencanaAlamP7Rt;
// use App\Models\Rt\TransaksiSaranaEkonomiP5Rt;
// use App\Models\Rt\TransaksiOperatorSinyalP6Rt;

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

        $data = [
            'p2' => DB::table("rt_p2")
                ->join("rt_p4", "rt_p2.id_p4", "=", "rt_p4.id")
                ->join("rt_p3", "rt_p4.id_p3_rw", "=", "rt_p3.id")
                ->where("rt_p2.id_p4", $idP4)
                ->select(
                    "rt_p2.*",
                    "rt_p4.rt as rt",
                    "rt_p3.nama_rw as rw"
                )
                ->first(),
            'p3' => DB::table('rt_p3 as p3')
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
                ->first(),
            'p4' => $p4,
            'p5' => DB::table('rt_p5')->where('id_p4', $idP4)->first(),
            'p6' => DB::table('rt_p6')->where('id_p4', $idP4)->first(),
            'p8' => DB::table('rt_p8')->where('id_p4', $idP4)->first(),
            'p7' => DB::table('rt_p7')->where('id_p4', $idP4)->first(),
            'master_p502' => MasterJenisIndustriRTM::select('id', 'jenis_industri')->get(),
            'p502' => TransaksiIndustriP5RTM::where('id_p4', $idP4)
                ->get(),
            'master_p508' => MasterSaranaEkonomiRTM::select('id', 'sarana_ekonomi')->get(),
            'p508' => TransaksiSaranaEkonomiP5RTM::where('id_p4', $idP4)
                ->get(),

            'master_p607' => MasterOperatorSinyalRTM::select('id', 'nama_operator')->get(),
            'p607' => TransaksiOperatorSinyalP6RTM::where('id_p4', $idP4)
                ->get(),
            'master_p609' => MasterTvRadioRTM::select('id', 'program_tv_radio')->get(),
            'p609' => TransaksiTvRadioP6RTM::where('id_p4', $idP4)
                ->get(),

            'master_p706' => MasterGunaSumberRTM::select('id', 'jenis_penggunaan')->get(),
            'p706' => TransaksiGunaSumberP7RTM::where('id_p4', $idP4)->get(),
            'master_p709' => MasterLingkunganRTM::select('id', 'jenis_lingkungan')->get(),
            'p709' => TransaksiPencemaranP7RTM::where('id_p4', $idP4)->get(),

            'master_p713' => MasterBencanaAlamRTM::select('id', 'jenis_bencana')->get(),
            'p713' => TransaksiBencanaAlamP7RTM::where('id_p4', $idP4)->get(),



            'master_p801' => MasterPendidikanRTM::select('id', 'jenjang_pendidikan')->get(),
            'p801' => DB::table('transaksi_pendidikan_p8_rt')->join(
                'master_pendidikan_rt',
                'transaksi_pendidikan_p8_rt.id_master_pendidikan',
                '=',
                'master_pendidikan_rt.id'
            )
                ->where('transaksi_pendidikan_p8_rt.id_p4', $idP4)->get(),

            'master_p901' => MasterKesehatanRTM::select('id', 'jenjang_kesehatan')->get(),
            'p901' => TransaksiKesehatanP9RTM::where('id_p4', $idP4)->get(),

            'master_p902' => MasterKlbRTM::select('id', 'jenis_klb')->get(),
            'p902' => TransaksiKlbP9RTM::where('id_p4', $idP4)->get(),

            'p10' => DB::table('rt_p10')->where('id_p4', $idP4)->first(),
            'p1004' => DB::table('rt_p1004')->where('id_p4', $idP4)->get(),

            'master_p1009' => MasterLembagaMasyarakatRTM::select('id', 'nama_lembaga')->get(),
            'p1009' => TransaksiLembagaMasyarakatP10RTM::where('id_p4', $idP4)->get(),

            'p11' => DB::table('rt_p11')->where('id_p4', $idP4)->first(),

            'master_p1101' => MasterPerkelahianRTM::select('id', 'jenis_perkelahian')->get(),
            'p1101' => TransaksiPerkelahianP11RTM::where('id_p4', $idP4)->get(),

             'master_p1102' => MasterKejahatanRTM::select('id', 'jenis_kejahatan')->get(),
            'p1102' => TransaksiKejahatanP11RTM::where('id_p4', $idP4)->get(),
        ];



        // return response()->json([
        //     'status' => true,
        //     'data' => $data,
        // ]);

        $rtNumber = isset($p4->rt) ? str_pad($p4->rt, 2, '0', STR_PAD_LEFT) : 'data';
        $filename = "formulir_rt_{$rtNumber}.pdf";

        $pdf = Pdf::loadView('pages.rt.export', [
            'data' => $data
        ]);

        if (request()->has('stream')) {
            return $pdf->stream($filename);
        }

        return $pdf->download($filename);
    }
}
