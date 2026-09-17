<?php

namespace App\Http\Controllers\Desa\P5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Desa\P5\P502;
use App\Models\Desa\P5\P5;
use App\Models\Desa\DesaP2;
use App\Support\PublicUploadPath;
use Illuminate\Support\Facades\Log;

class P502Controller extends Controller
{
    public function index($id_p5)
    {
        $p5 = P5::findOrFail($id_p5);
        $data = P502::where('id_desa_p5', $p5->id)->get();
        // dd($id_p5);
        return view('pages.desa.forms.p502', compact('p5', 'data'));
    }

    public function store(Request $request)
    {
        $idDesaP5 = $request->id_desa_p5;
        $p5 = P5::findOrFail($idDesaP5);
        $idSurvey = $p5->id_survey ?? session('id_survey');

        if (! $idSurvey) {
            return redirect()->back()->with('error', 'Survey belum dipilih. Silakan buka form dari menu Desa terlebih dahulu.');
        }

        try {
            DB::beginTransaction();
            $request->validate([
                'dokumen_peraturan_kepdes' => 'required|file|mimes:pdf',
            ]);
            $idOtomatis = "DSP502-" . strtotime(date("Y-m-d H:i:s"));
         if ($request->hasFile('dokumen_peraturan_kepdes')) {
                $file = $request->file('dokumen_peraturan_kepdes');
                $filename = $idOtomatis . '.pdf';
                $uploadPath = PublicUploadPath::ensure('dokumen/p5/dokumen_peraturan_kepdes');

				$file->move($uploadPath, $filename);
            }

            P502::create([
                'id'                        => $idOtomatis,
                'id_desa_p5'                => $idDesaP5,
                'id_survey'                 => $idSurvey,
                'no_dokumen'                => $request->no_dokumen,
                'bulan'                     => $request->bulan,
                'tentang'                   => $request->tentang,
                // 'dokumen_peraturan_kepdes'    => $filePath,
                'id_buat'                   => Auth::user()->id,
                'tgl_buat'                  => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data P502 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P502: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P502::findOrFail($id);
        $request->validate([
            'dokumen_peraturan_kepdes' => 'nullable|file|mimes:pdf',
        ]);

        $uploadPath = PublicUploadPath::ensure('dokumen/p5/dokumen_peraturan_kepdes');

    if ($request->hasFile('dokumen_peraturan_kepdes')) {

        // Nama file PDF = ID (tanpa simpan ke DB)
        $filename = $id . ".pdf";
        $oldPath = $uploadPath . '/' . $filename;

        // Hapus file lama jika ada
        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        // Upload file baru
        $file = $request->file('dokumen_peraturan_kepdes');
        $file->move($uploadPath, $filename);
    }
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P502 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P502::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data P502 berhasil dihapus.');
    }

    public function fromP2($id_survey)
    {
        $p5 = P5::where('id_survey', $id_survey)->first();

        if (!$p5) {
            return redirect()->back()->with('error', 'Data P5 belum dibuat untuk desa ini.');
        }

        $p2 = DesaP2::where('id_survey', $id_survey)->first();
        if ($p2) {
            session([
                'id_survey' => $p2->id_survey,
                'id_desa' => $p2->id,
            ]);
        }

        return redirect()->route('desa-p502.index', $p5->id);
    }
}
