<?php

namespace App\Http\Controllers\Keluarga\P4;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P2\KgP2M;
use App\Models\Keluarga\P4\KgP4M;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P4KgController extends Controller
{
    public function index()
    {
        // dd(session('id_kg_p2'));
        // dd(session()->all());

        $idKgP2 = session('id_kg_p2');

        if (!$idKgP2) {
            return redirect()->back()->with('error', 'ID Keluarga tidak ditemukan.');
        }

        $data = KgP4M::where('id_kg_p2', $idKgP2)->get();
        $datap2 = KgP2M::where('id', $idKgP2)->first();

        return view('pages.keluarga.p4.kgp4', compact('data', 'datap2'));
    }


    public function store(Request $request)
    {
        // dd(session('id_kg_p2'));
        $idKgP2 = session('id_kg_p2');
        $userId = Auth::user()->id;
        $datap2 = KgP2M::where('id', $idKgP2)->first();
        $request->validate([
            'tempat_tinggal_yg_ditempati' => 'required',
            'status_lahan_tempat_tinggal_yg_ditempati' => 'required',
        ]);

        try {
            KgP4M::create([
                'id' => "KGP4-" . strtotime(date("Y-m-d H:i:s")),
                'id_buat' => $userId,
                'id_survey' => $datap2->id_survey,
                'tgl_buat' => now(),
                'tgl_update' => now(),

                // Data dari form
                'id_kg_p2' => $idKgP2,
                'tempat_tinggal_yg_ditempati' => $request->tempat_tinggal_yg_ditempati,
                'status_lahan_tempat_tinggal_yg_ditempati' => $request->status_lahan_tempat_tinggal_yg_ditempati,
                'luas_lantai_ttl_terluas' => $request->luas_lantai_ttl_terluas,
                'luas_lahan_ttl_terluas' => $request->luas_lahan_ttl_terluas,
                'jns_lantai_ttl_terluas' => $request->jns_lantai_ttl_terluas,
                'dinding_sebagian_besar_rumah' => $request->dinding_sebagian_besar_rumah,
                'jendela' => $request->jendela,
                'atap' => $request->atap,
                'penerangan_rumah' => $request->penerangan_rumah,
                'energi_untuk_memasak' => $request->energi_untuk_memasak,
                'sumber_kayu_bakar' => $request->sumber_kayu_bakar,
                'sumber_kayu_bakar' => $request->sumber_kayu_bakar,
                'tempat_pembuangan_sampah' => $request->tempat_pembuangan_sampah,
                'fasilitas_mck' => $request->fasilitas_mck,
                'sumber_air_mandi' => $request->sumber_air_mandi,
                'fasilitas_bab' => $request->fasilitas_bab,
                'sumber_air_minum' => $request->sumber_air_minum,
                'tmpt_pembuangan_limbah_cair' => $request->tmpt_pembuangan_limbah_cair,
                'rumah_berada_dibawah' => $request->rumah_berada_dibawah,
                'rumah_di_bantaran_sungai' => $request->rumah_di_bantaran_sungai,
                'rumah_dilereng_bukit_gunung' => $request->rumah_dilereng_bukit_gunung,
                'secara_keseluruhan_kondisi_rumah' => $request->secara_keseluruhan_kondisi_rumah,
                'blt_dana_desa' => $request->blt_dana_desa,
                'pkh' => $request->pkh,
                'bst' => $request->bst,
                'banpres' => $request->banpres,
                'bantuan_umkm' => $request->bantuan_umkm,
                'bantuan_pekerja' => $request->bantuan_pekerja,
                'bantuan_anak' => $request->bantuan_anak,
                'lainnya' => $request->lainnya,
            ]);

            return redirect()->back()->with('success', 'Data keluarga berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p4: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = KgP4M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = KgP4M::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->update(array_merge(
            $request->all(),
            ['id_update' => Auth::user()->id, 'tgl_update' => Carbon::now()]
        ));

        return redirect()->back()->with('success', 'Data keluarga berhasil diperbarui');
    }

    public function destroy($id)
    {
        KgP4M::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Data keluarga P3 berhasil dihapus.');
    }
}
