<?php

namespace App\Http\Controllers\Desa\P10;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P10\P10;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P10Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P10 yang sesuai dengan id_survey
        $data = P10::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p10', compact('data'));
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

            $p10 = P10::create([
                'id' => "DSP10-" . strtotime(date("Y-m-d H:i:s")),
                'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'sarana_yg_digunakan' => $request->sarana_yg_digunakan,
                'sarana_transportasi' => $request->sarana_transportasi,
                'angkutan_umum' => $request->angkutan_umum,
                'angkutan_umum_utama' => $request->angkutan_umum_utama,
                'jarak_tempuh' => $request->jarak_tempuh,
                'waktu_tempuh' => $request->waktu_tempuh,
                'biaya' => $request->biaya,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama p10 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p10: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P10::findOrFail($id);
        return view('pages.desa.forms.p10_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P10::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama p10 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P10::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama p10 berhasil dihapus.');
    }
}
