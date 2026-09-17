<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterJenisIndustriRTM;
use Illuminate\Support\Facades\Auth;

class MasterJenisIndustriRTController extends Controller
{
    public function index()
    {
        $data = MasterJenisIndustriRTM::all();
        return view('pages.master.masterjenisindustri', compact('data'));
    }

    public function store(Request $request)
    {
        $last = MasterJenisIndustriRTM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "MBA-010" -> 10
            $number = intval(substr($last->id, 4)) + 1;
        } else {
            $number = 1;
        }

        $newId = 'MJI-' . str_pad($number, 3, '0', STR_PAD_LEFT);


        // Simpan data
        $data = MasterJenisIndustriRTM::create([
            "id" => $newId,
            'jenis_industri' => $request->jenis_industri,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterJenisIndustriRTM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterJenisIndustriRTM::findOrFail($id);

            $data->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('jenisindustri.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterJenisIndustriRTM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterJenisIndustriRTM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
