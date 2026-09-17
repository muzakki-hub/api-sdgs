<?php

namespace App\Http\Controllers\Desa\P8;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P8\P8;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P8Controller extends Controller
{
    public function index()
    {
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        $lembaga = DB::table('master_lembaga_p800')->orderBy('nama_lembaga')->get();
        $data = DB::table('desa_p8')
            ->join('master_lembaga_p800', 'desa_p8.id_lembaga', '=', 'master_lembaga_p800.id_lembaga')
            ->where('desa_p8.id_survey', $idSurvey)
            ->select('desa_p8.*', 'master_lembaga_p800.nama_lembaga')
            ->get();

        return view('pages.desa.forms.p8', compact('lembaga', 'data'));
    }

    public function store(Request $request)
    {
        $idDesap2 = session('id_desa');
        $idSurvey = session('id_survey');
        // dd([
        //     'id_survey_session' => session('id_survey'),
        //     'id_desa_session' => session('id_desa'),
        //     'request' => $request->all()
        // ]);
        try {

            DB::beginTransaction();

            $p8 = P8::create([
                'id' => "DSP8-" . strtotime(date("Y-m-d H:i:s")),
                // 'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'id_lembaga' => $request->id_lembaga,
                'jml_pengurus' => $request->jml_pengurus,
                'jml_anggota' => $request->jml_anggota,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama P8 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P8: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P8::findOrFail($id);
        return view('pages.desa.forms.p8_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P8::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P8 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P8::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P8 berhasil dihapus.');
    }
}
