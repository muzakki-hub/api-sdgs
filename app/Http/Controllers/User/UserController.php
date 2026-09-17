<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('jabatan')->get();
        return view('pages.user.user', compact('users'));
    }

    public function store(Request $request)
    {

        try {

            $id = strtotime(now());
            $hp = $request->hp;

            // konversi 08 → 62
            if (Str::startsWith($hp, '08')) {
                $hp = '62' . substr($hp, 1);
            }

            User::create([
                "id" => $id,
                "nama" => $request->nama,
                "username" => $request->username,
                "hp" => $hp,
                "id_jabatan" => $request->id_jabatan,
                "status" => $request->status,
                "password" => Hash::make($request->password),   // <-- sesuai login
                "alamat" => $request->alamat,
                "id_buat" => Auth::user()->id,
                "is_logged_in" => false, // <-- penting untuk login controller
            ]);

            return redirect()->back()->with('success', 'User berhasil ditambahkan!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }


    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        // hp
        $hp = $request->hp;
        if (Str::startsWith($hp, '08')) {
            $hp = '62' . substr($hp, 1);
        }


        $user->update([
            'nama' => $request->nama,
            'username' => $request->username,
            'hp' => $hp,
            'id_jabatan' => $request->id_jabatan,
            'status' => $request->status,
            'is_logged_in' => $request->is_logged_in,
            'alamat' => $request->alamat,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
            'id_update' => Auth::user()->id,
        ]);

        return redirect()->route('userweb.index')->with('success', 'User berhasil diupdate!');
    }


    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // kalau user sedang login, jangan hapus tanpa reset is_logged_in
        $user->is_logged_in = false;
        $user->save();

        $user->delete();

        return back()->with('success', 'Data User berhasil dihapus.');
    }
}
