<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterPenyakitM;
use Illuminate\Support\Facades\Auth;

class MasterPenyakitController extends Controller
{
    public function index()
    {
        $dataP = MasterPenyakitM::all();
        $data = MasterPenyakitM::orderBy('jenis_penyakit')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data master penyakit berhasil dimuat',
            'data' => $data
        ]);
        return view('pages.master.masterpenyakit', compact('dataP'));
    }

    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = MasterPenyakitM::orderByDesc('id')->first();
        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id, 2)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'PY' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $data = MasterPenyakitM::create([
            "id" => $newId,
            'jenis_penyakit' => $request->jenis_penyakit,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterPenyakitM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterPenyakitM::findOrFail($id);

            // $request->validate([
            //     'deskripsi' => 'sometimes|required|string',
            // ]);

            $data->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('penyakit.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterPenyakitM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterPenyakitM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
