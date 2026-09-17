<?php

namespace App\Http\Controllers\Desa\P7;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Desa\P7\P705;
use App\Models\Desa\P7\P7;
use Illuminate\Support\Facades\Log;

class P705Controller extends Controller
{
    public function index($id_p7)
    {
        $p7 = P7::findOrFail($id_p7);
        $data = P705::where('id_desa_p7', $p7->id)->get();

        return view('pages.desa.forms.p705', compact('p7', 'data'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            P705::create([
                'id' => "DSP705-" . strtotime(date("Y-m-d H:i:s")),
                'id_desa_p7' => $request->id_desa_p7, // <== ini yang diisi dari hidden input
                'id_survey' => session('id_survey'),
                'pihak_kerjasama' => $request->pihak_kerjasama,
                'lingkup_kerjasama' => $request->lingkup_kerjasama,
                'akhir_kerjasama' => $request->akhir_kerjasama,
                'jml_jiwa' => $request->jml_jiwa,
                'nilai_kerjasama' => $request->nilai_kerjasama,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data P705 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P705::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama P705 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P705::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data P705 berhasil dihapus.');
    }

    public function fromP2($id_survey)
    {
        $P7 = \App\Models\Desa\P7\P7::where('id_survey', $id_survey)->first();

        if (!$P7) {
            return redirect()->back()->with('error', 'Data P7 belum dibuat untuk desa ini.');
        }

        return redirect()->route('desa-p705.index', $P7->id);
    }
}
