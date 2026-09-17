<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\Lembaga_P800;
use Illuminate\Support\Facades\Auth;

class MasterLembagaController extends Controller
{
    public function index()
    {
        $lembaga = Lembaga_P800::all();
        return view('pages.master.masterlembaga', compact('lembaga'));
        // return response()->json($data);
    }
    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = Lembaga_P800::orderByDesc('id_lembaga')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id_lembaga, 1)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'L' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $Lembaga_P800 = Lembaga_P800::create([
            "id_lembaga" => $newId,
            'nama_lembaga' => $request->nama_lembaga,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Lembaga_P800 berhasil ditambahkan!');
    }


    public function show(string $id)
    {
        $Lembaga_P800 = Lembaga_P800::findOrFail($id);
        return response()->json($Lembaga_P800);
    }

    public function update(Request $request, string $id)
    {
        try {
            $Lembaga_P800 = Lembaga_P800::findOrFail($id);

            // $request->validate([
            //     'deskripsi' => 'sometimes|required|string',
            // ]);

            $Lembaga_P800->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('lembaga.index')
                ->with('success', 'Lembaga_P800 berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // Jika aman, hapus Lembaga_P800
        // Lembaga_P800::destroy($id);

        // return back()->with('success', 'Data Lembaga_P800 berhasil dihapus.');
        $master = Lembaga_P800::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
