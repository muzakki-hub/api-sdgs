<?php

namespace App\Http\Controllers\Desa\P5;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P5\P5;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P5Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P5 yang sesuai dengan id_survey
        $data = P5::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p5', compact('data'));
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
            $p5 = P5::create([
                'id' => "DSP5-" . strtotime(date("Y-m-d H:i:s")),
                // 'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'rpjm_berlaku' => $request->rpjm_berlaku,
                'rkp_desa' => $request->rkp_desa,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama p5 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p5: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P5::findOrFail($id);
        return view('pages.desa.forms.p5_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P5::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama p5 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P5::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama p5 berhasil dihapus.');
    }
}
