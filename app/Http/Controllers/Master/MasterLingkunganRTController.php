<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterLingkunganRTM;
use Illuminate\Support\Facades\Auth;

class MasterLingkunganRTController extends Controller
{
    public function index()
    {
        $data = MasterLingkunganRTM::all();
        return view('pages.master.masterlingkungan', compact('data'));
    }

    public function store(Request $request)
    {
        $last = MasterLingkunganRTM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "MBA-010" -> 10
            $number = intval(substr($last->id, 4)) + 1;
        } else {
            $number = 1;
        }

        $newId = 'MJL-' . str_pad($number, 3, '0', STR_PAD_LEFT);


        // Simpan data
        $data = MasterLingkunganRTM::create([
            "id" => $newId,
            'jenis_lingkungan' => $request->jenis_lingkungan,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterLingkunganRTM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterLingkunganRTM::findOrFail($id);

            $data->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('lingkungan.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterLingkunganRTM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
                $master = MasterLingkunganRTM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
