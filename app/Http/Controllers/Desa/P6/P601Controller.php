<?php

namespace App\Http\Controllers\Desa\P6;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P6\P601;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P601Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P601 yang sesuai dengan id_desa_p2
        $data = P601::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p601', compact('data'));
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

            $P601 = P601::create([
                'id' => "DSP601-" . strtotime(date("Y-m-d H:i:s")),
                // 'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'anggaran_pendapatan' => $request->anggaran_pendapatan,
                'apbn'  => $request-> apbn,
                'pades'  => $request-> pades,
                'pajak_daerah'  => $request-> pajak_daerah,
                'alokasi_dana_desa'  => $request-> alokasi_dana_desa,
                'apbd_prov'  => $request-> apbd_prov,
                'apbd_kab'  => $request-> apbd_kab,
                'hibah'  => $request-> hibah,
                'lain_lain'  => $request->lain_lain,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama P601 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P601: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P601::findOrFail($id);
        return view('pages.desa.forms.p601_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P601::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P601 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P601::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P601 berhasil dihapus.');
    }
}
