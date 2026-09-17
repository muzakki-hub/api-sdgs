<?php

namespace App\Http\Controllers\Individu\P1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Individu\P1\IdvP1M;
use Illuminate\Support\Facades\Auth;
use App\Models\Survey\Survey;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class P1IdvController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        $survey = Survey::whereDate('tgl_mulai', '<=', $today)
            ->whereDate('tgl_akhir', '>=', $today)
            ->get();
        $data = IdvP1M::with('survey')->get();
        return view('pages.individu.individu', compact('data', 'survey'));
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
            'no_kk' => 'required',
            'nik' => 'required',
            'nama' => 'required',
        ]);

        try {
            $individu = IdvP1M::create([
                'id' => "IDVP1-" . strtotime(date("Y-m-d H:i:s")),
                'id_survey' => $survey->id,
                'id_buat' => $userId,
                'tgl_buat' => now(),
                'tgl_update' => now(),

                // Data dari form
                'no_kk' => $request->no_kk,
                'nik' => $request->nik,
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tgl_lahir' => $request->tgl_lahir,
                'status_pernikahan' => $request->status_pernikahan,
                'agama' => $request->agama,
                'suku_bangsa' => $request->suku_bangsa,
                'warganegara' => $request->warganegara,
                'no_hp' => $request->no_hp,
                'no_wa' => $request->no_wa,
                'url_email_pribadi' => $request->url_email_pribadi,
                'url_facebook_pribadi' => $request->url_facebook_pribadi,
                'url_twitter_pribadi' => $request->url_twitter_pribadi,
                'url_instagram_pribadi' => $request->url_instagram_pribadi,
            ]);

            return redirect()->back()->with('success', 'Data Individu P1 berhasil ditambahkan!');
        } catch (\Throwable $e) {
            DB::rollBack();
            dd('Error:', $e->getMessage());
            Log::error('Gagal menyimpan p1: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan data.');
        }
    }

    public function show(string $id)
    {
        $data = IdvP1M::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = IdvP1M::find($id);

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

        return redirect()->back()->with('success', 'Data Individu P1 berhasil Di Update!');
    }

    public function destroy(string $id)
    {
        $p1 = IdvP1M::findOrFail($id);

        // 🔹 Cek apakah individu ini punya data di tabel lain
        $hasP2   = \App\Models\Individu\P2\IdvP2M::where('id_individu_p1', $id)->exists();
        $hasP204 = \App\Models\Individu\P2\IdvP204M::where('id_individu_p1', $id)->exists();
        $hasP4   = \App\Models\Individu\P4\IdvP4M::where('id_individu_p1', $id)->exists();
        $hasP401 = \App\Models\Individu\P4\IdvP401M::where('id_individu_p1', $id)->exists();
        $hasP402 = \App\Models\Individu\P4\IdvP402M::where('id_individu_p1', $id)->exists();

        // Jika salah satu punya data, blok hapus
        if ($hasP2 || $hasP204 || $hasP4 || $hasP401 || $hasP402) {
            return back()->with('error', 'Data Individu P1 tidak dapat dihapus karena masih memiliki data pada tabel P2, P204, P4, P401, atau P402.');
        }


        // 🔹 Kalau aman → hapus
        $p1->delete();

        return back()->with('success', 'Data Individu P1 berhasil dihapus karena tidak memiliki isian dan tidak terkait dengan tabel lain.');
    }
}
