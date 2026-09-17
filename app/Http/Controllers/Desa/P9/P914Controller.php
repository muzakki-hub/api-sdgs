<?php

namespace App\Http\Controllers\Desa\P9;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Desa\P9\P914;
use App\Models\Desa\P9\P9;
use Illuminate\Support\Facades\Log;

class P914Controller extends Controller
{
    public function index($id_p9)
    {
        $p9 = P9::findOrFail($id_p9);
        $data = P914::where('id_desa_p9', $p9->id)->get();

        return view('pages.desa.forms.p914', compact('p9', 'data'));
    }
 
    public function store(Request $request)
    {
        $idDesaP9 = $request->id_desa_p9; // hidden input dari form
        $idSurvey = session('id_survey'); // bisa juga ambil dari relasi kalau perlu

        // Cari nomor urut terakhir untuk desa P914 ini
        $lastNumber = P914::where('id_desa_p9', $idDesaP9)->max('komisaris_ke');
        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;

        try {
            DB::beginTransaction();

            P914::create([
                'id' => "DSP914-" . strtotime(date("Y-m-d H:i:s")),
                'id_desa_p9' => $idDesaP9,
                // 'id_survey' => $idSurvey,
                'komisaris_ke' => $nextNumber,
                'nama_komisaris' => $request->nama_komisaris,
                'nik_komisaris' => $request->nik_komisaris,
                'hp_komisaris' => $request->hp_komisaris,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data P914 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p914: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan: ' . $e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P914::findOrFail($id);
        $dataUtama->update($request->all());

        return redirect()->back()->with('success', 'Data utama p914 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P914::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data P914 berhasil dihapus.');
    }

    public function fromP2($id_survey)
    {
        $p9 = \App\Models\Desa\P9\P9::where('id_survey', $id_survey)->first();

        if (!$p9) {
            return redirect()->back()->with('error', 'Data P9 belum dibuat untuk desa ini.');
        }

        return redirect()->route('desa-p914.index', $p9->id);
    }
}
