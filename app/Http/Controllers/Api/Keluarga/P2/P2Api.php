<?php

namespace App\Http\Controllers\Api\Keluarga\P2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Keluarga\P2\KgP2M as P2;
use App\Models\Survey\Survey;
use Illuminate\Support\Facades\Auth;

class P2Api extends Controller
{
     /**
     * Tampilkan semua data P2 (Deskripsi Lokasi)
     */
    public function index()
    {
        $today = Carbon::today();

        // Ambil survey aktif
        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        // Ambil semua data lokasi keluarga (P2)
        $data = P2::with('survey')->get();

        return response()->json([
            'status' => true,
            'survey_aktif' => $survey,
            'data' => $data
        ]);
    }

    /**
     * Simpan data baru P2
     */
    public function store(Request $request)
    {
        $today = Carbon::today()->toDateString();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if (!$survey) {
            return back()->with('error', 'Tidak ada survey aktif untuk hari ini.');
        }

        $data = P2::create([
            'id' => "KGP2-" . strtotime(date("Y-m-d H:i:s")),
            'id_survey' => $survey->id,
            'no_kk' => $request->no_kk,
            'no_kk' => $request->no_kk,
            'nik_kk' => $request->nik_kk,
            // 'kode_provinsi' => $validated['kode_provinsi'],
            // 'kode_kabupaten' => $validated['kode_kabupaten'],
            // 'kode_kecamatan' => $validated['kode_kecamatan'],
            'kode_provinsi' => $request->kode_provinsi,
            'kode_kabupaten' => $request->kode_kabupaten,
            'kode_kecamatan' => $request->kode_kecamatan,
            'kode_desa' => $request->kode_desa,
            'rt' => $request->rt,
            'rw' => $request->rw,
            'nama_kpl_keluarga' => $request->nama_kpl_keluarga,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
            'telp_rumah' => $request->telp_rumah,
            
            'id_buat' => Auth::user()->id,
            'id_update' => Auth::user()->id,
            'tgl_buat' => now(),
            'tgl_update' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil disimpan',
            'data' => $data
        ]);
    }


    /**
     * Tampilkan detail P2 berdasarkan ID
     */
    public function show($id)
    {
        $data = P2::with('survey')->find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    /**
     * Update data P2
     */
    public function update(Request $request, $id)
    {
        $data = P2::find($id);

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

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil diperbarui',
            'data' => $data
        ]);
    }

    /**
     * Hapus data P2
     */
    public function destroy($id)
    {
        $data = P2::find($id);

        if (!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        $data->delete();

        return response()->json([
            'status' => true,
            'message' => 'Data keluarga berhasil dihapus'
        ]);
    }
}
