<?php

namespace App\Http\Controllers\Desa\P3;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Desa\P3\P3;
use Illuminate\Support\Str;


class P3Controller extends Controller
{
    public function index()
    {
        $idSurvey = session('id_survey'); // dari session yang diset sebelumnya

        if (!$idSurvey) {
            return redirect()->route('desa-p2.index')->with('error', 'Data P2 belum dipilih.');
        }

        $data = P3::where('id_survey', $idSurvey)->get();
        return view('pages.desa.forms.p3', compact('data'));
    }

    public function store(Request $request)
    {
        $idDesap2 = session('id_desa');
        $idSurvey = session('id_survey');

        try {

            DB::beginTransaction();

            $request->validate([
                'nik_kades' => 'nullable|digits:16',
                'nik_sekdes' => 'nullable|digits:16',
                'nik_bendes' => 'nullable|digits:16',
            ]);

            $p3 = P3::create([
                'id' => "DSP3-" . strtotime(date("Y-m-d H:i:s")),
                'id_survey' => $idSurvey,
                'nik_kades' => $request->nik_kades,
                'nama_kades' => $request->nama_kades,
                'hp_kades' => $request->hp_kades,
                'awal_jabatan_kades' => $request->awal_jabatan_kades,
                'nik_sekdes' => $request->nik_sekdes,
                'nama_sekdes' => $request->nama_sekdes,
                'hp_sekdes' => $request->hp_sekdes,
                'awal_jabatan_sekdes' => $request->awal_jabatan_sekdes,
                'nik_bendes' => $request->nik_bendes,
                'nama_bendes' => $request->nama_bendes,
                'hp_bendes' => $request->hp_bendes,
                'awal_jabatan_bendes' => $request->awal_jabatan_bendes,
                'nik_kpl_tu' => $request->nik_kpl_tu,
                'nama_kpl_tu' => $request->nama_kpl_tu,
                'hp_kpl_tu' => $request->hp_kpl_tu,
                'awal_jabatan_kpl_tu' => $request->awal_jabatan_kpl_tu,
                'nik_kpl_uang' => $request->nik_kpl_uang,
                'nama_kpl_uang' => $request->nama_kpl_uang,
                'hp_kpl_uang' => $request->hp_kpl_uang,
                'awal_jabatan_kpl_uang' => $request->awal_jabatan_kpl_uang,
                'nik_kpl_rencana' => $request->nik_kpl_rencana,
                'nama_kpl_rencana' => $request->nama_kpl_rencana,
                'hp_kpl_rencana' => $request->hp_kpl_rencana,
                'awal_jabatan_kpl_rencana' => $request->awal_jabatan_kpl_rencana,
                'nik_kepsek_pemerintahan' => $request->nik_kepsek_pemerintahan,
                'nama_kepsek_pemerintahan' => $request->nama_kepsek_pemerintahan,
                'hp_kepsek_pemerintahan' => $request->hp_kepsek_pemerintahan,
                'awal_jabatan_kepsek_pemerintahan' => $request->awal_jabatan_kepsek_pemerintahan,
                'nik_kepsek_kesejahteraan' => $request->nik_kepsek_kesejahteraan,
                'nama_kepsek_kesejahteraan' => $request->nama_kepsek_kesejahteraan,
                'hp_kepsek_kesejahteraan' => $request->hp_kepsek_kesejahteraan,
                'awal_jabatan_kepsek_kesejahteraan' => $request->awal_jabatan_kepsek_kesejahteraan,
                'nik_kepsek_pelayanan' => $request->nik_kepsek_pelayanan,
                'nama_kepsek_pelayanan' => $request->nama_kepsek_pelayanan,
                'hp_kepsek_pelayanan' => $request->hp_kepsek_pelayanan,
                'awal_jabatan_kepsek_pelayanan' => $request->awal_jabatan_kepsek_pelayanan,
                'nik_kpl_bpd' => $request->nik_kpl_bpd,
                'nama_kpl_bpd' => $request->nama_kpl_bpd,
                'hp_kpl_bpd' => $request->hp_kpl_bpd,
                'awal_jabatan_kpl_bpd' => $request->awal_jabatan_kpl_bpd,
                'id_buat' => Auth::user()->id,
                'tgl_buat' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data utama P3 berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            // dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan P3: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function edit($id)
    {
        $dataUtama = P3::findOrFail($id);
        return view('pages.desa.forms.p3_edit', compact('dataUtama'));
    }

    public function update(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $dataUtama = P3::findOrFail($id);

            $dataUtama->update([
                'nik_kades' => $request->nik_kades,
                'nama_kades' => $request->nama_kades,
                'hp_kades' => $request->hp_kades,
                'awal_jabatan_kades' => $request->awal_jabatan_kades,

                'nik_sekdes' => $request->nik_sekdes,
                'nama_sekdes' => $request->nama_sekdes,
                'hp_sekdes' => $request->hp_sekdes,
                'awal_jabatan_sekdes' => $request->awal_jabatan_sekdes,

                'nik_bendes' => $request->nik_bendes,
                'nama_bendes' => $request->nama_bendes,
                'hp_bendes' => $request->hp_bendes,
                'awal_jabatan_bendes' => $request->awal_jabatan_bendes,

                'nik_kpl_tu' => $request->nik_kpl_tu,
                'nama_kpl_tu' => $request->nama_kpl_tu,
                'hp_kpl_tu' => $request->hp_kpl_tu,
                'awal_jabatan_kpl_tu' => $request->awal_jabatan_kpl_tu,

                'nik_kpl_uang' => $request->nik_kpl_uang,
                'nama_kpl_uang' => $request->nama_kpl_uang,
                'hp_kpl_uang' => $request->hp_kpl_uang,
                'awal_jabatan_kpl_uang' => $request->awal_jabatan_kpl_uang,

                'nik_kpl_rencana' => $request->nik_kpl_rencana,
                'nama_kpl_rencana' => $request->nama_kpl_rencana,
                'hp_kpl_rencana' => $request->hp_kpl_rencana,
                'awal_jabatan_kpl_rencana' => $request->awal_jabatan_kpl_rencana,

                'nik_kepsek_pemerintahan' => $request->nik_kepsek_pemerintahan,
                'nama_kepsek_pemerintahan' => $request->nama_kepsek_pemerintahan,
                'hp_kepsek_pemerintahan' => $request->hp_kepsek_pemerintahan,
                'awal_jabatan_kepsek_pemerintahan' => $request->awal_jabatan_kepsek_pemerintahan,

                'nik_kepsek_kesejahteraan' => $request->nik_kepsek_kesejahteraan,
                'nama_kepsek_kesejahteraan' => $request->nama_kepsek_kesejahteraan,
                'hp_kepsek_kesejahteraan' => $request->hp_kepsek_kesejahteraan,
                'awal_jabatan_kepsek_kesejahteraan' => $request->awal_jabatan_kepsek_kesejahteraan,

                'nik_kepsek_pelayanan' => $request->nik_kepsek_pelayanan,
                'nama_kepsek_pelayanan' => $request->nama_kepsek_pelayanan,
                'hp_kepsek_pelayanan' => $request->hp_kepsek_pelayanan,
                'awal_jabatan_kepsek_pelayanan' => $request->awal_jabatan_kepsek_pelayanan,

                'nik_kpl_bpd' => $request->nik_kpl_bpd,
                'nama_kpl_bpd' => $request->nama_kpl_bpd,
                'hp_kpl_bpd' => $request->hp_kpl_bpd,
                'awal_jabatan_kpl_bpd' => $request->awal_jabatan_kpl_bpd,

                'id_update' => Auth::user()->id,
                'tgl_update' => now(),
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Data utama P3 berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal update P3: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }

    public function destroy($id)
    {
        P3::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data utama P3 berhasil dihapus.');
    }
}
