<?php

namespace App\Http\Controllers\Desa\P3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P3\P3;
use App\Models\Desa\P3\AnggotaBpd;
use Illuminate\Support\Facades\DB;

class BpdController extends Controller
{
    public function index($id_p3)
    {
        $p3 = P3::findOrFail($id_p3);
        $data = AnggotaBpd::where('id_desa_p3', $p3->id)->get();

        return view('pages.desa.forms.p3-bpd', compact('p3', 'data'));
    }

    public function store(Request $request)
    {
        $idDesaP3 = $request->id_desa_p3;
        $idSurvey = session('id_survey');
 
        // Cari nomor urut terakhir untuk desa P3 ini
        $lastNumber = AnggotaBpd::where('id_desa_p3', $idDesaP3)
            ->max('anggota_ke');
        // Jika belum ada data, mulai dari 1
        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
        AnggotaBpd::create([
            'id' => "DSP3BPD-" . strtotime(date("Y-m-d H:i:s")),
            'id_desa_p3' => $idDesaP3,
            'anggota_ke' => $nextNumber,
            'nik_anggota_bpd' => $request->nik_anggota_bpd,
            'nama_anggota_bpd' => $request->nama_anggota_bpd,
            'hp_anggota_bpd' => $request->hp_anggota_bpd ?? null,
            'awal_jabatan_anggota_bpd' => $request->awal_jabatan_anggota_bpd,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return back()->with('success', 'Data Anggota BPD berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $bpd = AnggotaBpd::findOrFail($id);
        $bpd->update([
            'anggota_ke' => $request->anggota_ke,
            'nik_anggota_bpd' => $request->nik_anggota_bpd,
            'nama_anggota_bpd' => $request->nama_anggota_bpd,
            'hp_anggota_bpd' => $request->hp_anggota_bpd,
            'awal_jabatan_anggota_bpd' => $request->awal_jabatan_anggota_bpd,
        ]);

        return back()->with('success', 'Data Anggota BPD berhasil diperbarui');
    }

    public function destroy($id)
    {
        AnggotaBpd::findOrFail($id)->delete();
        return back()->with('success', 'Data Anggota BPD berhasil dihapus');
    }

        public function fromP2($id_survey)
    {
        $p3 = \App\Models\Desa\P3\P3::where('id_survey', $id_survey)->first();

        if (!$p3) {
            return redirect()->back()->with('error', 'Data P3 belum dibuat untuk desa ini.');
        }

        return redirect()->route('desa-p3Bpd.index', $p3->id);
    }
}
