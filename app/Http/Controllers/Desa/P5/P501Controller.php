<?php

namespace App\Http\Controllers\Desa\P5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Desa\P5\P501;
use App\Models\Desa\P5\P5;
use App\Models\Desa\DesaP2;
use App\Support\PublicUploadPath;
use Illuminate\Support\Facades\Log;

class P501Controller extends Controller
{
    public function index($id_p5)
    {
        $p5 = P5::findOrFail($id_p5);
        $data = P501::where('id_desa_p5', $p5->id)->get();

        return view('pages.desa.forms.p501', compact('p5', 'data'));
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
                'dokumen_peraturan_desa' => 'required|file|mimes:pdf',
            ]);
            $idOtomatis = "DSP501-" . strtotime(date("Y-m-d H:i:s"));
            if ($request->hasFile('dokumen_peraturan_desa')) {
                $file = $request->file('dokumen_peraturan_desa');
                $filename = $idOtomatis . '.pdf';
                $uploadPath = PublicUploadPath::ensure('dokumen/p5/peraturan_desa');

				$file->move($uploadPath, $filename);
            }

            P501::create([
                'id' => $idOtomatis,
                'id_desa_p5' => $idDesaP5,
                'id_survey' => $idSurvey,
                'no_dokumen' => $request->no_dokumen,
                'bulan' => $request->bulan,
                'tentang' => $request->tentang,
                // 'dokumen_peraturan_desa' => $filePath,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data P501 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p501: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

	public function update(Request $request, $id)
{
    $data = P501::findOrFail($id);

    $request->validate([
        'edit_dokumen_peraturan_desa' => 'nullable|file|mimes:pdf',
    ]);

    // SAMA dengan STORE
    $uploadPath = PublicUploadPath::ensure('dokumen/p5/peraturan_desa');

    if ($request->hasFile('edit_dokumen_peraturan_desa')) {

        $filename = $id . ".pdf";
        $oldFile = $uploadPath . '/' . $filename;

        if (file_exists($oldFile)) {
            unlink($oldFile);
        }

        $request->file('edit_dokumen_peraturan_desa')->move($uploadPath, $filename);
    }

    $data->update($request->except('edit_dokumen_peraturan_desa'));

    return back()->with('success', 'Data berhasil diperbarui.');
}

    public function destroy($id)
    {
        P501::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data P501 berhasil dihapus.');
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

        return redirect()->route('desa-p501.index', $p5->id);
    }
}
