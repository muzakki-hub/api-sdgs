<?php

namespace App\Http\Controllers\Api\Formulir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// MODEL DATA INDIVIDU
use App\Models\Individu\P1\IdvP1M;
use App\Models\Individu\P2\IdvP2M;
use App\Models\Individu\P2\IdvP204M;
use App\Models\Individu\P4\IdvP4M;
use App\Models\Individu\P4\IdvP401M;
use App\Models\Individu\P4\IdvP402M;
use App\Models\Individu\P5\IdvP5M;

// MASTER TABLE
use App\Models\Master\MasterPenghasilanM;
use App\Models\Master\MasterPenyakitM;
use App\Models\Master\MasterSarkesM;

// TABEL DESA (sesuaikan dengan folder)
use App\Models\Desa\DesaP2;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\CoverDataService;
use Illuminate\Support\Facades\DB;

class FormulirIdvController extends Controller
{
    public function download(Request $request, $id)
    {
        try {
            // ==============
            // Ambil data utama P1
            // ==============
            $p1 = IdvP1M::find($id);
            if (!$p1) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data P1 tidak ditemukan'
                ], 404);
            }

            // Check Nama Kepala Keluarga
            $namaKkParam = $request->query('nama_kepala_keluarga');
            $confirmEmpty = $request->boolean('confirm_empty');
            $namaKepalaKeluarga = CoverDataService::resolveNamaKepalaKeluarga($p1, $namaKkParam);

            // Jika belum ada di DB dan tidak dikirim via parameter dan bukan batch/confirm_empty
            if ($namaKepalaKeluarga === null && !$confirmEmpty && !$request->has('batch')) {
                return response()->json([
                    'status' => false,
                    'require_prompt' => true,
                    'prompt_title' => 'Cetak Formulir Individu',
                    'prompt_message' => 'Nama Kepala Keluarga belum terdata pada KK ini. Masukkan Nama Kepala Keluarga untuk cover formulir:',
                    'prompt_param' => 'nama_kepala_keluarga',
                ], 200);
            }

            // ==============
            // Cover Data
            // ==============
            $enumerator = CoverDataService::resolveEnumerator($p1, $request);
            $wilayah = CoverDataService::resolveWilayah();
            $alamatDusun = !empty($p1->alamat) ? $p1->alamat : (!empty($p1->no_kk) ? DB::table('kg_p2')->where('no_kk', $p1->no_kk)->value('alamat') : null);

            $cover = [
                'level' => 'individu',
                'header_img' => CoverDataService::getHeaderImageBase64(),
                'no_kk' => $p1->no_kk ?? '-',
                'nama_kepala_keluarga' => $namaKepalaKeluarga ?: '',
                'alamat_dusun' => $alamatDusun ?: '',
                'desa' => $wilayah['desa'],
                'kecamatan' => $wilayah['kecamatan'],
                'kabupaten' => $wilayah['kabupaten'],
                'enumerator_nama' => $enumerator['nama'],
                'enumerator_jabatan' => $enumerator['jabatan'],
                'enumerator_ttd' => $enumerator['ttd'] ?? '',
            ];

            // ==============
            // Ambil data individu
            // ==============
            $p2   = IdvP2M::where('id_individu_p1', $id)->first();
            $p204 = IdvP204M::where('id_individu_p1', $id)->get()->keyBy('id_master_penghasilan');
            $p4   = IdvP4M::where('id_individu_p1', $id)->first();
            $p401 = IdvP401M::where('id_individu_p1', $id)->get()->keyBy('id_master_penyakit');
            $p402 = IdvP402M::where('id_individu_p1', $id)->get()->keyBy('id_master_sarkes');
            $p5   = IdvP5M::where('id_individu_p1', $id)->first();

            // ==============
            // Master
            // ==============
            $mpenghasilan = MasterPenghasilanM::orderBy('nama_komoditas')->get();
            $mpenyakit    = MasterPenyakitM::orderBy('jenis_penyakit')->get();
            $msarkes      = MasterSarkesM::orderBy('nama_sarkes')->get();

            // Data desa
            $desaP2 = $wilayah['desa_p2'] ?? DesaP2::first();

            // ==============
            // Try untuk DomPDF
            // ==============
            try {
                $pdf = Pdf::loadView('pages.pdf.formulir_individu', compact(
                    'cover',
                    'p1',
                    'p2',
                    'p204',
                    'p4',
                    'p401',
                    'p402',
                    'p5',
                    'mpenghasilan',
                    'mpenyakit',
                    'msarkes',
                    'desaP2'
                ))->setPaper('A4', 'portrait');

            } catch (\Exception $pdfError) {
                return response()->json([
                    'status'  => false,
                    'message' => 'Gagal membuat PDF',
                    'error'   => $pdfError->getMessage()
                ], 500);
            }

            // ==============
            // Return PDF
            // ==============
            $filename = 'Formulir_SDGS_' . str_replace(' ', '_', $p1->nama) . '.pdf';
            if ($request->has('stream')) {
                return $pdf->stream($filename);
            }
            return $pdf->download($filename);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Terjadi kesalahan server',
                'error'   => $e->getMessage()
            ], 500);
        }
    }


    public function view(Request $request, $id)
    {
        $p1 = IdvP1M::find($id);
        if (!$p1) abort(404);

        $namaKkParam = $request->query('nama_kepala_keluarga');
        $namaKepalaKeluarga = CoverDataService::resolveNamaKepalaKeluarga($p1, $namaKkParam);
        $enumerator = CoverDataService::resolveEnumerator($p1, $request);
        $wilayah = CoverDataService::resolveWilayah();
        $alamatDusun = !empty($p1->no_kk) ? DB::table('kg_p2')->where('no_kk', $p1->no_kk)->value('alamat') : null;

        $cover = [
            'level' => 'individu',
            'header_img' => CoverDataService::getHeaderImageBase64(),
            'no_kk' => $p1->no_kk ?? '-',
            'nama_kepala_keluarga' => $namaKepalaKeluarga ?: '',
            'alamat_dusun' => $alamatDusun ?: '',
            'desa' => $wilayah['desa'],
            'kecamatan' => $wilayah['kecamatan'],
            'kabupaten' => $wilayah['kabupaten'],
            'enumerator_nama' => $enumerator['nama'],
            'enumerator_jabatan' => $enumerator['jabatan'],
        ];

        $p2   = IdvP2M::where('id_individu_p1', $id)->first();
        $p204 = IdvP204M::where('id_individu_p1', $id)->get()->keyBy('id_master_penghasilan');
        $p4   = IdvP4M::where('id_individu_p1', $id)->first();
        $p401 = IdvP401M::where('id_individu_p1', $id)->get()->keyBy('id_master_penyakit');
        $p402 = IdvP402M::where('id_individu_p1', $id)->get()->keyBy('id_master_sarkes');
        $p5   = IdvP5M::where('id_individu_p1', $id)->first();

        $mpenghasilan = MasterPenghasilanM::orderBy('nama_komoditas')->get();
        $mpenyakit    = MasterPenyakitM::orderBy('jenis_penyakit')->get();
        $msarkes      = MasterSarkesM::orderBy('nama_sarkes')->get();

        $desaP2 = $wilayah['desa_p2'] ?? DesaP2::first();

        return view('pages.pdf.formulir_individu', compact(
            'cover',
            'p1',
            'p2',
            'p204',
            'p4',
            'p401',
            'p402',
            'p5',
            'mpenghasilan',
            'mpenyakit',
            'msarkes',
            'desaP2'
        ));
    }
}
