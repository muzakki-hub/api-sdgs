<?php

namespace App\Http\Controllers\Jabatan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jabatan\Jabatan as ModelsJabatanM;
use Illuminate\Support\Facades\Auth;

class JabatanController extends Controller
{
    public function index()
    {
        $jabatan = ModelsJabatanM::all();
        return view('pages.desa.jabatan', compact('jabatan'));
    }

    public function store(Request $request)
    {
        $userId = Auth::user()->id;
        $request->validate([
            'id' => 'required|string|max:25',
            'nama_jabatan' => 'required|string',
        ]);

        $jabatan = ModelsJabatanM::create([
            "id" => $request->id,
            'nama_jabatan' => $request->nama_jabatan,
            'id_buat' => $userId,
            'tgl_buat' => now(),
        ]);

        return redirect()->back()->with('success', 'Jabatan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id' => 'required|string|max:25|unique:jabatan,id,' . $id, // pastikan id baru unik kecuali id lama
            'nama_jabatan' => 'required|string|max:25',
        ]);

        $jabatan = ModelsJabatanM::findOrFail($id);
        $jabatan->update([
            'id' => $request->id,
            'nama_jabatan' => $request->nama_jabatan,
            'id_update' => Auth::user()->id,
            'tgl_update' => now(),
        ]);

        return redirect()->route('jabatan.index')
            ->with('success', 'Jabatan berhasil diupdate!');
    }

    public function show(string $id)
    {
        return response()->json(ModelsJabatanM::findOrFail($id));
    }

    public function destroy(string $id)
    {
        ModelsJabatanM::destroy($id);
        return back()->with('success', 'Data Jabatan berhasil dihapus.');
    }
}
