<?php

namespace App\Http\Controllers\Api\Formulir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


use App\Models\Desa\DesaP2;
use App\Models\Keluarga\P2\KgP2M;
use App\Models\Keluarga\P4\KgP4M;
use App\Models\Keluarga\P4\KgP421M;
use App\Models\Keluarga\P4\KgP422M;
use App\Models\Keluarga\P4\KgP423M;
use App\Models\Keluarga\P4\KgP424M;
use App\Models\Master\MasterApstM;


use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use App\Services\CoverDataService;

class FormulirKgController extends Controller
{
    public function download(Request $request, $id_p2)
{
    try {
        // ========================
        // Ambil Data P2
        // ========================
        $p2 = KgP2M::with(['provinsi', 'kabupaten', 'kecamatan', 'desa'])
            ->where('id', $id_p2)
            ->first();

        if (!$p2) {
            return response()->json(['message' => 'Data P2 tidak ditemukan'], 404);
        }

        // Ambil data relasi lain
        $p4   = KgP4M::where('id_kg_p2', $p2->id)->first();
        $p421 = KgP421M::with('pendidikan')->where('id_kg_p2', $p2->id)->get();
        $p422 = KgP422M::with('masterFaskes')->where('id_kg_p2', $p2->id)->get();
        $p423 = KgP423M::with('masterTenkes')->where('id_kg_p2', $p2->id)->get();
        $p424 = KgP424M::with('masterApst')->where('id_kg_p2', $p2->id)->get();
        $masterApst = MasterApstM::get();

        $enumerator = CoverDataService::resolveEnumerator($p2, $request);
        $wilayah = CoverDataService::resolveWilayah();

        $cover = [
            'level' => 'keluarga',
            'header_img' => CoverDataService::getHeaderImageBase64(),
            'no_kk' => $p2->no_kk ?? '-',
            'nama_kepala_keluarga' => $p2->nama_kpl_keluarga ?? '',
            'alamat_dusun' => $p2->alamat ?? '',
            'desa' => $p2->desa?->nama ?? $wilayah['desa'],
            'kecamatan' => $p2->kecamatan?->nama ?? $wilayah['kecamatan'],
            'kabupaten' => $p2->kabupaten?->nama ?? $wilayah['kabupaten'],
            'enumerator_nama' => $enumerator['nama'],
            'enumerator_jabatan' => $enumerator['jabatan'],
            'enumerator_ttd' => $enumerator['ttd'] ?? '',
        ];

        $user = CoverDataService::getEnumeratorUser($p2, $request);

        $data = [
            'cover'      => $cover,
            'user'       => $user,
            'p2'         => $p2,
            'p4'         => $p4,
            'p421'       => $p421,
            'p422'       => $p422,
            'p423'       => $p423,
            'p424'       => $p424,
            'masterApst' => $masterApst,
        ];

        // ========================
        // Generate PDF
        // ========================
        try {
            $pdf = Pdf::loadView('pages.pdf.formulir_keluarga', $data);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Gagal membuat PDF',
                'error'   => $e->getMessage()
            ], 500);
        }

        $filename = "sdgs-keluarga-{$p2->id}.pdf";
        if ($request->has('stream')) {
            return $pdf->stream($filename);
        }
        return $pdf->download($filename);

    } catch (\Exception $e) {

        // ========================
        // Error general: database, data kosong, dll
        // ========================
        return response()->json([
            'status'  => false,
            'message' => 'Terjadi kesalahan pada server',
            'error'   => $e->getMessage(),  // untuk debug API
            // 'trace' => $e->getTrace()     // aktifkan jika ingin lihat detail error
        ], 500);
    }
}

    public function view(Request $request, $id_p2)
    {
        return $this->download($request, $id_p2);
    }
}
