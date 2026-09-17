<?php

namespace App\Http\Controllers\Desa\P9;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P9\P9;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class P9Controller extends Controller
{
    public function index()
    {
        // dd(session()->all());
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        // Ambil data P9 yang sesuai dengan id_desa_p2
        $data = P9::where('id_survey', $idSurvey)->get();


        return view('pages.desa.forms.p9', compact('data'));
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

            $p9 = P9::create([
                'id' => "DSP9-" . strtotime(date("Y-m-d H:i:s")),
                'id_desa_p2' => $idDesap2,
                'id_survey' => $idSurvey,
                'nama_bumdes' => $request->nama_bumdes,
                'email' => $request->email,
                'web_bumdes' => $request->web_bumdes,
                'fb_bumdes' => $request->fb_bumdes,
                'twitter_bumdes' => $request->twitter_bumdes,
                'alamat_desa' => $request->alamat_desa,
                'yt_bumdes' => $request->yt_bumdes,
                // 'modal_awal' => $request->modal_awal,
                'modal_awal' => implode(',', $request->modal_awal),
                'omset_setahun' => $request->omset_setahun,
                'keuntungan_bersih' => $request->keuntungan_bersih,
                'keuntungan_kotor' => $request->keuntungan_kotor,
                'aset_bumdes' => $request->aset_bumdes,
                'sumbangan_padesa' => $request->sumbangan_padesa,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();
            return redirect()->back()->with('success', 'Data utama p9 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p9: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P9::findOrFail($id);
        $modal_awal = explode(',', $dataUtama->modal_awal);
        return view('pages.desa.forms.p9_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        $dataUtama = P9::findOrFail($id);

        $dataUtama->update([
            'nama_bumdes'        => $request->nama_bumdes,
            'email'              => $request->email,
            'alamat_desa'        => $request->alamat_desa,
            'web_bumdes'         => $request->web_bumdes,
            'fb_bumdes'          => $request->fb_bumdes,
            'twitter_bumdes'     => $request->twitter_bumdes,
            'yt_bumdes'          => $request->yt_bumdes,

            // 🔥 WAJIB → gabungkan array jadi string
            'modal_awal'         => implode(',', $request->modal_awal),

            'omset_setahun'      => $request->omset_setahun,
            'keuntungan_kotor'   => $request->keuntungan_kotor,
            'keuntungan_bersih'  => $request->keuntungan_bersih,
            'aset_bumdes'        => $request->aset_bumdes,
            'sumbangan_padesa'   => $request->sumbangan_padesa,
        ]);

        return redirect()->back()->with('success', 'Data utama p9 berhasil diperbarui.');
    }

    public function destroy($id)
    {
        P9::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama p9 berhasil dihapus.');
    }
}
