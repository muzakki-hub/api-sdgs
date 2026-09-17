<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterFaskesM;
use Illuminate\Support\Facades\Auth;

class MasterFaskesController extends Controller
{
    public function index()
    {
        $faskes = MasterFaskesM::all();
        return view('pages.master.masterfaskes', compact('faskes'));
        // return response()->json($data);
    }

    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = MasterFaskesM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id, 1)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'F' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $faskes = MasterFaskesM::create([
            "id" => $newId,
            'jenjang_kesehatan' => $request->jenjang_kesehatan,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $faskes = MasterFaskesM::findOrFail($id);
        return response()->json($faskes);
    }

    public function update(Request $request, string $id)
    {
        try {
            $faskes = MasterFaskesM::findOrFail($id);

            // $request->validate([
            //     'deskripsi' => 'sometimes|required|string',
            // ]);

            $faskes->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('faskes.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterFaskesM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterFaskesM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
