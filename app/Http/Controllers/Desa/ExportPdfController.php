<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;


// Semua model
use App\Models\Desa\DesaP2 as p2;
use App\Models\Desa\P3\P3;
use App\Models\Desa\P3\PegawaiLainnya;
use App\Models\Desa\P3\AnggotaBpd;
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
use App\Models\Desa\P10\P10;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ExportPdfController extends Controller
{
    public function export($id_survey)
    {
        // Ambil ID P3 dulu
        $p3 = P3::where('id_survey', $id_survey)->first();
        $id_desa_p3 = $p3?->id; // null-safe operator
        if (!$p3) {
            $p3 = (object)[
                'nama_kades' => null,
                'nik_kades' => null,
                'hp_kades' => null,
                'awal_jabatan_kades' => null,
                'nama_sekdes' => null,
                'nik_sekdes' => null,
                'hp_sekdes' => null,
                'awal_jabatan_sekdes' => null,
                'nama_bendes' => null,
                'nik_bendes' => null,
                'hp_bendes' => null,
                'awal_jabatan_bendes' => null,
                'nama_kpl_tu' => null,
                'nik_kpl_tu' => null,
                'hp_kpl_tu' => null,
                'awal_jabatan_kpl_tu' => null,
                'nama_kpl_uang' => null,
                'nik_kpl_uang' => null,
                'hp_kpl_uang' => null,
                'awal_jabatan_kpl_uang' => null,
                'nama_kpl_rencana' => null,
                'nik_kpl_rencana' => null,
                'hp_kpl_rencana' => null,
                'awal_jabatan_kpl_rencana' => null,
                'nama_kepsek_pemerintahan' => null,
                'nik_kepsek_pemerintahan' => null,
                'hp_kepsek_pemerintahan' => null,
                'awal_jabatan_kepsek_pemerintahan' => null,
                'nama_kepsek_kesejahteraan' => null,
                'nik_kepsek_kesejahteraan' => null,
                'hp_kepsek_kesejahteraan' => null,
                'awal_jabatan_kepsek_kesejahteraan' => null,
                'nama_kepsek_pelayanan' => null,
                'nik_kepsek_pelayanan' => null,
                'hp_kepsek_pelayanan' => null,
                'awal_jabatan_kepsek_pelayanan' => null,
                'nama_kpl_bpd' => null,
                'nik_kpl_bpd' => null,
                'hp_kpl_bpd' => null,
                'awal_jabatan_kpl_bpd' => null,
            ];
        }

        // Ambil pegawai lainnya dan anggota BPD berdasarkan id_desa_p3
        $pegawai = $id_desa_p3
            ? PegawaiLainnya::where('id_desa_p3', $id_desa_p3)->get()
            : collect();

        $bpd = $id_desa_p3
            ? AnggotaBpd::where('id_desa_p3', $id_desa_p3)->get()
            : collect();

        $p601 = P601::where('id_survey', $id_survey)->first();
        if (!$p601) {
            $p601 = (object)[
                'anggaran_pendapatan' => null,
                'apbn' => null,
                'pades' => null,
                'pajak_daerah' => null,
                'alokasi_dana_desa' => null,
                'apbd_prov' => null,
                'apbd_kab' => null,
                'hibah' => null,
                'lain_lain' => null,
            ];
        }
        $p602 = P602::where('id_survey', $id_survey)->first();
        if (!$p602) {
            $p602 = (object)[
                'anggaran_pengeluaran' => null,
                'penyelenggaraan_desa' => null,
                'pembangunan_desa' => null,
                'pemberdayaan_desa' => null,
                'bina_masyarakat' => null,
                'belanja_modal' => null,
                'bumdes' => null,
                'lainnya' => null,
            ];
        }

        $p7 = P7::where('id_survey', $id_survey)->first();
        if (!$p7) {
            $p7 = (object)[
                'teknologi' => null,
                'internet' => null,
                'info_desa' => null,
                'keuangan_desa' => null,
                'srt_tidak_mampu' => null,
                'blm_ektp' => null,
                'blm_kk' => null,
                'nama_pdesa' => null,
                'jk_pdesa' => null,
                'hp_pdesa' => null,
            ];
        }
        // Ambil ID P3 dulu
        $p9 = P9::where('id_survey', $id_survey)->first();
        $id_desa_p9 = $p9?->id; // null-safe operator

        // Ambil pegawai lainnya dan anggota BPD berdasarkan id_desa_p3
        $p914 = $id_desa_p9
            ? P914::where('id_desa_p9', $id_desa_p9)->get()
            : collect();

        $p923 = $id_desa_p9
            ? P923::where('id_desa_p9', $id_desa_p9)->get()
            : collect();
        $p932 = $id_desa_p9
            ? P932::where('id_desa_p9', $id_desa_p9)->get()
            : collect();
        $p941 = $id_desa_p9
            ? P941::where('id_desa_p9', $id_desa_p9)->get()
            : collect();

        // Ambil semua data berdasarkan ID survey
        $data = [
            'user'   => Auth::user(),
            'p2' => P2::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
                ->where('id_survey', $id_survey)
                ->first(),

            'p3'   => $p3, // sudah ambil di atas
            'pegawai' => $pegawai,
            'bpd' => $bpd,
            'p4'   => P4::where('id_survey', $id_survey)->get(),
            'p5'   => P5::where('id_survey', $id_survey)->first(),
            'p501' => P501::where('id_survey', $id_survey)->get(),
            'p502' => P502::where('id_survey', $id_survey)->get(),
            'p503' => P503::where('id_survey', $id_survey)->get(),
            'p601' => $p601,
            'p602' => $p602,
            'p603' => P603::where('id_survey', $id_survey)->get(), // collection
            'p7'   => $p7,
            'p705' => P705::where('id_survey', $id_survey)->get(),
            'p8'   => P8::where('id_survey', $id_survey)->get(),
            'p9'   => P9::where('id_survey', $id_survey)->first(),
            'p914' => $p914,
            'p923' => $p923,
            'p932' => $p932,
            'p941' => $p941,
            'p10'  => P10::where('id_survey', $id_survey)->get(),
        ];

        // load view PDF
        $pdf = PDF::loadView('pages.desa.export.pdf', $data);

        return $pdf->download("sdgs-desa-$id_survey.pdf");
    }
}
