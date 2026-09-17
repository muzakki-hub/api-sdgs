<?php

namespace App\Http\Controllers\Desa\P9;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Desa\P9\P941;
use App\Models\Desa\P9\P9;
use Illuminate\Support\Facades\Log;

class P941Controller extends Controller
{
        public function index($id_p9)
    {
        $p9 = P9::findOrFail($id_p9);
        $data = P941::where('id_desa_p9', $p9->id)->get();

        return view('pages.desa.forms.p941', compact('p9', 'data'));
    }

    public function store(Request $request)
    {
        $idDesaP9 = $request->id_desa_p9; // hidden input dari form
        $idSurvey = session('id_survey'); // bisa juga ambil dari relasi kalau perlu
        try {
            DB::beginTransaction();

            P941::create([
                'id' => "DSP941-" . strtotime(date("Y-m-d H:i:s")),
                'id_desa_p9' => $idDesaP9,
                // 'id_survey' => $idSurvey,
                'unit_usaha_bumdes' => $request->unit_usaha_bumdes,
                'jml_unit_usaha' => $request->jml_unit_usaha,
                'jml_pekerja' => $request->jml_pekerja,
                'keuntungan_bersih' => $request->keuntungan_bersih,
                'omset_thn_lalu' => $request->omset_thn_lalu,
                'aset_thn_lalu' => $request->aset_thn_lalu,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data P941 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p941: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P941::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama p941 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P941::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data P941 berhasil dihapus.');
    }

    public function fromP2($id_survey)
    {
        $p9 = \App\Models\Desa\P9\P9::where('id_survey', $id_survey)->first();

        if (!$p9) {
            return redirect()->back()->with('error', 'Data P9 belum dibuat untuk desa ini.');
        }

        return redirect()->route('desa-p941.index', $p9->id);
    }
}
