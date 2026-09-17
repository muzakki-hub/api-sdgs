<?php

namespace App\Http\Controllers\Keluarga\P2;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Keluarga\P2\KgP2M;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P2KgController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->get();
        $data = KgP2M::with('survey')->get();
        return view('pages.keluarga.keluarga', compact('data', 'survey'));
    }

    public function show_survey()
    {
        $today = Carbon::today();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->get();
        $keluarga = KgP2M::all();

        return view('pages.keluarga.forms.p2', compact('keluarga', 'survey'));
    }

    public function store(Request $request)
    {
        // Ambil tanggal hari ini
        $today = Carbon::today()->toDateString();

        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->first();

        if (!$survey) {
            return back()->with('error', 'Tidak ada survey aktif untuk hari ini.');
        }
        $userId = Auth::user()->id;
        $request->validate([
            'kode_provinsi' => 'required|string',
            'kode_kabupaten' => 'required|string',
            'kode_kecamatan' => 'required|string',
            'kode_desa' => 'required|string',
        ]);

        // // Validasi lanjutan sesuai aturan kondisional
        if ($request->filled('meteran_rumah') && !$request->filled('no_meteran')) {
            return back()->withErrors(['no_meteran' => 'Nomer Meteran Rumah wajib diisi jika Meteran Rumah diisi.'])->withInput();
        }
        if ($request->filled('meteran_rumah') && !$request->filled('daya_meteran_rumah')) {
            return back()->withErrors(['daya_meteran_rumah' => 'Daya Meteran Rumah wajib diisi jika Meteran Rumah diisi.'])->withInput();
        }

        try {
            $keluarga = KgP2M::create([
                'id' => "KGP2-" . strtotime(date("Y-m-d H:i:s")),
                'id_survey' => $survey->id,
                'id_buat' => $userId,
                'tgl_buat' => now(),
                'tgl_update' => now(),

                // Data dari form
                'kode_provinsi' => $request->kode_provinsi,
                'kode_kabupaten' => $request->kode_kabupaten,
                'kode_kecamatan' => $request->kode_kecamatan,
                'kode_desa' => $request->kode_desa,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'nama_kpl_keluarga' => $request->nama_kpl_keluarga,
                'no_kk' => $request->no_kk,
                'no_hp' => $request->no_hp,
                'telp_rumah' => $request->telp_rumah,
                'alamat' => $request->alamat,
                'meteran_rumah' => $request->meteran_rumah,
            ]);

            return redirect()->back()->with('success', 'Data keluarga berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p5: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = KgP2M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = KgP2M::find($id);

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

    public function destroy(string $id)
    {
        $p2 = KgP2M::findOrFail($id);

        // 🔹 Cek apakah individu ini punya data di tabel lain
        $hasP3   = \App\Models\Keluarga\P3\KgP3M::where('id_kg_p2', $id)->exists();
        $hasP4 = \App\Models\Keluarga\P4\KgP4M::where('id_kg_p2', $id)->exists();
        $hasP421   = \App\Models\Keluarga\P4\KgP421M::where('id_kg_p2', $id)->exists();
        $hasP422 = \App\Models\Keluarga\P4\KgP422M::where('id_kg_p2', $id)->exists();
        $hasP423 = \App\Models\Keluarga\P4\KgP423M::where('id_kg_p2', $id)->exists();
        $hasP424 = \App\Models\Keluarga\P4\KgP424M::where('id_kg_p2', $id)->exists();

        // Jika salah satu punya data, blok hapus
        if ($hasP3 || $hasP3 || $hasP4 || $hasP421 || $hasP422 || $hasP423 || $hasP424) {
            return back()->with('error', 'Data Keluarga P2 tidak dapat dihapus karena masih memiliki data pada tabel P3,P4,P421,P422,P423,P424.');
        }


        // 🔹 Kalau aman → hapus
        $p2->delete();

        return back()->with('success', 'Data Keluarga P2 berhasil dihapus karena tidak memiliki isian dan tidak terkait dengan tabel lain.');
    }

    // public function setSession(Request $request)
    // {
    //     try {
    //         session([
    //             'id_keluarga' => $request->id_keluarga,
    //             'id_survey' => $request->id_survey
    //         ]);

    //         return response()->json(['status' => 'ok']);
    //     } catch (\Exception $e) {
    //         return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
    //     }
    // }
}
