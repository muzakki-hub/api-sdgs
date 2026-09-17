<?php

namespace App\Http\Controllers\Desa\P6;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P6\P602;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P602Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P602 yang sesuai dengan id_desa_p2
        $data = P602::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p602', compact('data'));
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

            $P602 = P602::create([
                'id' => "DSP602-" . strtotime(date("Y-m-d H:i:s")),
                // 'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'anggaran_pengeluaran' => $request->anggaran_pengeluaran,
                'penyelenggaraan_desa'  => $request->penyelenggaraan_desa,
                'pembangunan_desa'  => $request->pembangunan_desa,
                'pemberdayaan_desa'  => $request->pemberdayaan_desa,
                'bina_masyarakat'  => $request->bina_masyarakat,
                'belanja_modal'  => $request->belanja_modal,
                'bumdes'  => $request->bumdes,
                'lainnya'  => $request->lainnya,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama P602 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P602: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P602::findOrFail($id);
        return view('pages.desa.forms.p602_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P602::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P602 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P602::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P602 berhasil dihapus.');
    }
}
