<?php

namespace App\Http\Controllers\Desa\P7;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P7\P7;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P7Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P7 yang sesuai dengan id_survey
        $data = P7::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p7', compact('data'));
    }

    public function store(Request $request)
    {
        $idDesap2 = session('id_desa');
        $idSurvey = session('id_survey');
        // dd($idSurvey);  
        // dd([
        //     'id_survey_session' => session('id_survey'),
        //     'id_desa_session' => session('id_desa'),
        //     'request' => $request->all()
        // ]);
        try {

            DB::beginTransaction();

            $P7 = P7::create([
                'id' => "DSP7-" . strtotime(date("Y-m-d H:i:s")),
                // 'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'teknologi' => $request->teknologi,
                'internet'  => $request->internet,
                'info_desa'  => $request->info_desa,
                'keuangan_desa'  => $request->keuangan_desa,
                'srt_tidak_mampu'  => $request->srt_tidak_mampu,
                'blm_ektp'  => $request->blm_ektp,
                'blm_kk'  => $request->blm_kk,
                'nama_pdesa'  => $request->nama_pdesa,
                'jk_pdesa'  => $request->jk_pdesa,
                'hp_pdesa'  => $request->hp_pdesa,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama P7 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P7: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P7::findOrFail($id);
        return view('pages.desa.forms.p7_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P7::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P7 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P7::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P7 berhasil dihapus.');
    }
}
