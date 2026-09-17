<?php

namespace App\Http\Controllers\Desa\P3;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P3\P3;
use App\Models\Desa\P3\PegawaiLainnya;
use Illuminate\Support\Facades\DB;

class PegawaiController extends Controller
{
    public function index($id_p3)
    {
        $p3 = P3::findOrFail($id_p3);
        $data = PegawaiLainnya::where('id_desa_p3', $p3->id)->get();

        return view('pages.desa.forms.p3-pegawai', compact('p3', 'data'));
    }

    public function store(Request $request)
    {
        $idDesaP3 = $request->id_desa_p3;
        $idSurvey = session('id_survey');
        // Cari nomor urut terakhir untuk desa P3 ini
        $lastNumber = PegawaiLainnya::where('id_desa_p3', $idDesaP3)
            ->max('pegawai_ke');
        // Jika belum ada data, mulai dari 1
        $nextNumber = $lastNumber ? $lastNumber + 1 : 1;
        PegawaiLainnya::create([
            'id' => "DSP3PG-" . strtotime(date("Y-m-d H:i:s")),
            'id_desa_p3'                => $idDesaP3,
            'id_survey'                 => $idSurvey,
            'pegawai_ke'                => $nextNumber,
            'nik_pegawai_desa'          => $request->nik_pegawai_desa,
            'nama_pegawai_desa'         => $request->nama_pegawai_desa,
            'hp_pegawai_desa'           => $request->hp_pegawai_desa ?? null,
            'awal_jabatan_pegawai_desa' => $request->awal_jabatan_pegawai_desa,
            'id_buat'                   => Auth::user()->id,
            'tgl_buat'                  => now(),
        ]);

        return back()->with('success', 'Data Pegawai berhasil disimpan');
    }

    public function update(Request $request, $id)
    {
        $pegawai = PegawaiLainnya::findOrFail($id);
        $pegawai->update([
            'pegawai_ke'                    => $request->pegawai_ke,
            'nik_pegawai_desa'              => $request->nik_pegawai_desa,
            'nama_pegawai_desa'             => $request->nama_pegawai_desa,
            'hp_pegawai_desa'               => $request->hp_pegawai_desa,
            'awal_jabatan_pegawai_desa'     => $request->awal_jabatan_pegawai_desa,
            'id_update'                     => Auth::user()->id,
            'tgl_update'                    => now(),
        ]); 

        return back()->with('success', 'Data Pegawai berhasil diperbarui');
    }

    public function destroy($id)
    {
        PegawaiLainnya::findOrFail($id)->delete();
        return back()->with('success', 'Data Pegawai berhasil dihapus');
    }
    public function fromP2($id_survey)
    {
        $p3 = \App\Models\Desa\P3\P3::where('id_survey', $id_survey)->first();

        if (!$p3) {
            return redirect()->back()->with('error', 'Data P3 belum dibuat untuk desa ini.');
        }

        return redirect()->route('desa-p3Pegawai.index', $p3->id);
    }
}
