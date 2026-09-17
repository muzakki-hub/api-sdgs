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

class FormulirIdvController extends Controller
{
    public function download($id)
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
        $desaP2 = DesaP2::first();

        // ==============
        // Try untuk DomPDF
        // ==============
        try {
            $pdf = Pdf::loadView('pages.pdf.formulir_individu', compact(
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

            // Error khusus PDF
            return response()->json([
                'status'  => false,
                'message' => 'Gagal membuat PDF',
                'error'   => $pdfError->getMessage()
            ], 500);
        }

        // ==============
        // Return PDF
        // ==============
        return $pdf->download(
            'Formulir_SDGS_' . str_replace(' ', '_', $p1->nama) . '.pdf'
        );

    } catch (\Exception $e) {

        // Error general
        return response()->json([
            'status'  => false,
            'message' => 'Terjadi kesalahan server',
            'error'   => $e->getMessage()
        ], 500);
    }
}


    public function view($id)
    {
        $p1 = IdvP1M::find($id);
        if (!$p1) abort(404);

        $p2   = IdvP2M::where('id_individu_p1', $id)->first();
        $p204 = IdvP204M::where('id_individu_p1', $id)->get()->keyBy('id_master_penghasilan');
        $p4   = IdvP4M::where('id_individu_p1', $id)->first();
        $p401 = IdvP401M::where('id_individu_p1', $id)->get()->keyBy('id_master_penyakit');
        $p402 = IdvP402M::where('id_individu_p1', $id)->get()->keyBy('id_master_sarkes');
        $p5   = IdvP5M::where('id_individu_p1', $id)->first();

        $mpenghasilan = MasterPenghasilanM::orderBy('nama_komoditas')->get();
        $mpenyakit    = MasterPenyakitM::orderBy('jenis_penyakit')->get();
        $msarkes      = MasterSarkesM::orderBy('nama_sarkes')->get();

        // Data desa
        $desaP2 = DesaP2::first();

        return view('pages.pdf.formulir_individu', compact(
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
