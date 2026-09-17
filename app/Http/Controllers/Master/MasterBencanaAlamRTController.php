<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterBencanaAlamRTM;
use Illuminate\Support\Facades\Auth;

class MasterBencanaAlamRTController extends Controller
{
    public function index()
    {
        $data = MasterBencanaAlamRTM::all();
        return view('pages.master.masterbencana', compact('data'));
    }

    public function store(Request $request)
    {
        $last = MasterBencanaAlamRTM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "MBA-010" -> 10
            $number = intval(substr($last->id, 4)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format MBA-xxx
        $newId = 'MBA-' . str_pad($number, 3, '0', STR_PAD_LEFT);


        // Simpan data
        $data = MasterBencanaAlamRTM::create([
            "id" => $newId,
            'jenis_bencana' => $request->jenis_bencana,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $faskes = MasterBencanaAlamRTM::findOrFail($id);
        return response()->json($faskes);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterBencanaAlamRTM::findOrFail($id);

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

            return redirect()->route('bencana.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $master = MasterBencanaAlamRTM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
