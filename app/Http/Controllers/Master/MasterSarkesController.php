<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterSarkesM;
use Illuminate\Support\Facades\Auth;

class MasterSarkesController extends Controller
{
    public function index()
    {
        $dataS = MasterSarkesM::all();
        $data = MasterSarkesM::orderBy('nama_sarkes')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data master sarkes berhasil dimuat',
            'data' => $data
        ]);
        return view('pages.master.mastersarkes', compact('dataS'));
    }

    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = MasterSarkesM::orderByDesc('id')->first();
        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id, 2)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'SK' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $data = MasterSarkesM::create([
            "id" => $newId,
            'nama_sarkes' => $request->nama_sarkes,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterSarkesM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterSarkesM::findOrFail($id);

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

            return redirect()->route('sarkes.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterSarkesM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterSarkesM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
