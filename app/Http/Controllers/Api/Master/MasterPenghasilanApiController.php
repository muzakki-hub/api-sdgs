<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Master\MasterPenghasilanM;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MasterPenghasilanApiController extends Controller
{
    public function index()
    {
        $data = MasterPenghasilanM::orderBy('nama_komoditas')->get();

        return response()->json([
            'status' => true,
            'message' => 'Data master penghasilan berhasil dimuat',
            'data' => $data
        ]);
    }
    public function store(Request $request)
    {
        // Ambil ID terakhir yang paling besar (L001, L002, ... L999)
        $last = MasterPenghasilanM::orderByDesc('id')->first();
        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "L015" -> 15
            $number = intval(substr($last->id, 2)) + 1;
        } else {
            $number = 1;
        }

        // Buat ID baru dengan format Lxxx
        $newId = 'MP' . str_pad($number, 3, '0', STR_PAD_LEFT);

        // Simpan data
        $data = MasterPenghasilanM::create([
            "id" => $newId,
            'nama_komoditas' => $request->nama_komoditas,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterPenghasilanM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterPenghasilanM::findOrFail($id);

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

            return redirect()->route('penghasilan.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterPenghasilanM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterPenghasilanM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
