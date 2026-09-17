<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterApstM;
use Illuminate\Support\Facades\Auth;

class MasterApstController extends Controller
{
    public function index()
    {
        $apst = MasterApstM::all();
        return view('pages.master.masteraksessarpras', compact('apst'));
        // return response()->json($data);
    }
    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = MasterApstM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id, 1)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'A' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $MasterApstM = MasterApstM::create([
            "id" => $newId,
            'nama_akses' => $request->nama_akses,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'MasterApstM berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $MasterApstM = MasterApstM::findOrFail($id);
        return response()->json($MasterApstM);
    }

    public function update(Request $request, string $id)
    {
        try {
            $MasterApstM = MasterApstM::findOrFail($id);

            // $request->validate([
            //     'deskripsi' => 'sometimes|required|string',
            // ]);

            $MasterApstM->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('apst.index')
                ->with('success', 'MasterApstM berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // Jika aman, hapus MasterApstM
        // MasterApstM::destroy($id);

        // return back()->with('success', 'Data MasterApstM berhasil dihapus.');
        $master = MasterApstM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
