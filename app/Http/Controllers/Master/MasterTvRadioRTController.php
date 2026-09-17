<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Master\MasterTvRadioRTM;
use Illuminate\Support\Facades\Auth;

class MasterTvRadioRTController extends Controller
{
    public function index()
    {
        $data = MasterTvRadioRTM::all();
        return view('pages.master.mastertvradio', compact('data'));
    }

    public function store(Request $request)
    {
        $last = MasterTvRadioRTM::orderByDesc('id')->first();

        // Tentukan nomor berikutnya
        if ($last) {
            // Ambil angka dari ID, contoh: "MBA-010" -> 10
            $number = intval(substr($last->id, 4)) + 1;
        } else {
            $number = 1;
        }

        $newId = 'MTR-' . str_pad($number, 3, '0', STR_PAD_LEFT);


        // Simpan data
        $data = MasterTvRadioRTM::create([
            "id" => $newId,
            'program_tv_radio' => $request->program_tv_radio,
            'id_buat' => Auth::user()->id,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Data berhasil ditambahkan!');
    }

    public function show(string $id)
    {
        $data = MasterTvRadioRTM::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request, string $id)
    {
        try {
            $data = MasterTvRadioRTM::findOrFail($id);

            $data->update(array_merge(
                $request->all(),
                [
                    'id_update' => Auth::user()->id,
                    'tgl_update' => now(),
                ]
            ));

            return redirect()->route('tvradio.index')
                ->with('success', 'Data berhasil diupdate!');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        // MasterTvRadioRTM::destroy($id);

        // return back()->with('success', 'Data berhasil dihapus.');
        $master = MasterTvRadioRTM::findOrFail($id);

        if ($master->transaksi()->count() > 0) {
            return back()->with('error', 'Data tidak dapat dihapus karena sedang digunakan.');
        }

        $master->delete();

        return back()->with('success', 'Data berhasil dihapus.');
    }
}
