<?php

namespace App\Http\Controllers\Desa\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P4\P4;
use App\Support\PublicUploadPath;
use Illuminate\Support\Facades\Log;

class P4Controller extends Controller
{
    public function index()
    {
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P5 yang sesuai dengan id_desa_p2
        $data = P4::where('id_survey', $idSurvey)->get();

        return view('pages.desa.forms.p4', compact('data'));
    }

    public function store(Request $request)
    {
        $idDesap2 = session('id_desa');
        $idSurvey = session('id_survey');
        try {
            $idOtomatis = "DSP4-" . strtotime(date("Y-m-d H:i:s"));
            DB::beginTransaction();
            $request->validate([
                'dokumen_musyawarah' => 'required|file|mimes:pdf',
            ]);
            // if ($request->hasFile('dokumen_musyawarah')) {
            //     $file = $request->file('dokumen_musyawarah');
            //     $filename = $idOtomatis . '.pdf';
            //     $file->move(public_path('dokumen/musyawarah'), $filename);
            // }
         if ($request->hasFile('dokumen_musyawarah')) {
                $file = $request->file('dokumen_musyawarah');
                $filename = $idOtomatis . '.pdf';
                $uploadPath = PublicUploadPath::ensure('dokumen/musyawarah');

				$file->move($uploadPath, $filename);
            }
            $p4 = P4::create([
                'id' => $idOtomatis,
                'id_survey' => $idSurvey,
                'bulan_ke' => $request->bulan_ke,
                'agenda_musyawarah' => base64_encode($request->agenda_musyawarah),
                'tgl_musyawarah' => $request->tgl_musyawarah,
                // 'dokumen_musyawarah' => $filePath,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Data utama P4 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P4: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P4::findOrFail($id);
        return view('pages.desa.forms.p4_edit', compact('dataUtama'));
    }

    public function show($id)
{
    $data = P4::findOrFail($id);

    $filename = $id . '.pdf';

    $uploadPath = PublicUploadPath::ensure('dokumen/musyawarah');
    $filePath = $uploadPath . '/' . $filename;

    return response()->json([
        'id' => $data->id,
        'agenda_musyawarah' => $data->agenda_musyawarah,
        'file_exists' => file_exists($filePath),
        'file_url' => asset('dokumen/musyawarah/' . $filename) . '?v=' . time(),
    ]);
}


public function update(Request $request, $id)
{
    $dataUtama = P4::findOrFail($id);

    $request->validate([
        'dokumen_musyawarah' => 'nullable|file|mimes:pdf',
    ]);

    DB::beginTransaction();

    $uploadPath = PublicUploadPath::ensure('dokumen/musyawarah');

    if ($request->hasFile('dokumen_musyawarah')) {

        // filename selalu ID.pdf
        $filename = $id . ".pdf";
        $oldPath = $uploadPath . '/' . $filename;

        if (file_exists($oldPath)) {
            unlink($oldPath);
        }

        $request->file('dokumen_musyawarah')->move($uploadPath, $filename);
    }

    $dataUtama->update([
        'bulan_ke' => $request->bulan_ke,
        'agenda_musyawarah' => base64_encode($request->agenda_musyawarah),
        'tgl_musyawarah' => $request->tgl_musyawarah,
        'id_update' => Auth::user()->id,
        'tgl_update' => now(),
    ]);

    DB::commit();

    return back()->with('success', 'Data utama P4 berhasil diperbarui.');
}



    public function destroy($id)
    {
        P4::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P4 berhasil dihapus.');
    }
}
