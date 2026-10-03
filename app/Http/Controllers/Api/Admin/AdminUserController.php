<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AdminUserController extends Controller
{
    /**
     * Get list of all users with jabatan.
     */
    public function index(Request $request)
    {
        try {
            $users = User::with('jabatan')
                ->orderBy('id_jabatan', 'asc')
                ->orderBy('nama', 'asc')
                ->get();

            $formatted = $users->map(function ($u) {
                return [
                    'id' => (string) $u->id,
                    'nama' => $u->nama,
                    'username' => $u->username,
                    'hp' => $u->hp,
                    'id_jabatan' => (string) $u->id_jabatan,
                    'nama_jabatan' => optional($u->jabatan)->nama_jabatan ?: 'Pengguna',
                    'status' => $u->status ?: 'Y',
                    'alamat' => $u->alamat,
                    'rw_tugas' => $u->rw_tugas ? (string) $u->rw_tugas : null,
                    'rt_tugas' => $u->rt_tugas ? (string) $u->rt_tugas : null,
                    'is_restricted' => !empty($u->rw_tugas),
                    'is_logged_in' => (bool) $u->is_logged_in,
                ];
            });

            return response()->json([
                'status' => true,
                'message' => 'Daftar pengguna berhasil dimuat',
                'data' => $formatted,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal mengambil data pengguna: ' . $th->getMessage(),
                'data' => [],
            ], 500);
        }
    }

    /**
     * Get single user detail.
     */
    public function show($id)
    {
        try {
            $user = User::with('jabatan')->findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Data pengguna berhasil ditemukan',
                'data' => [
                    'id' => (string) $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'hp' => $user->hp,
                    'id_jabatan' => (string) $user->id_jabatan,
                    'nama_jabatan' => optional($user->jabatan)->nama_jabatan ?: 'Pengguna',
                    'status' => $user->status ?: 'Y',
                    'alamat' => $user->alamat,
                    'rw_tugas' => $user->rw_tugas ? (string) $user->rw_tugas : null,
                    'rt_tugas' => $user->rt_tugas ? (string) $user->rt_tugas : null,
                    'is_restricted' => !empty($user->rw_tugas),
                    'is_logged_in' => (bool) $user->is_logged_in,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Pengguna tidak ditemukan: ' . $th->getMessage(),
            ], 404);
        }
    }

    /**
     * Create a new user.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama' => 'required|string|max:100',
            'username' => 'required|string|max:100|unique:user,username',
            'password' => 'required|string|min:4',
            'id_jabatan' => 'required|string|max:10',
            'status' => 'nullable|string|in:Y,N',
            'hp' => 'nullable|string|max:50',
            'alamat' => 'nullable|string',
            'rw_tugas' => 'nullable|string|max:10',
            'rt_tugas' => 'nullable|string|max:10',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
            ], 422);
        }

        try {
            $hp = $request->hp;
            if ($hp && Str::startsWith($hp, '08')) {
                $hp = '62' . substr($hp, 1);
            }

            $rw = $request->filled('rw_tugas') ? trim((string)$request->rw_tugas) : null;
            $rt = $request->filled('rt_tugas') ? trim((string)$request->rt_tugas) : null;
            if (empty($rw)) {
                $rw = null;
                $rt = null;
            }

            $id = (string) (time() . rand(10, 99));

            $creatorId = Auth::check() ? Auth::id() : '1';

            $user = User::create([
                'id' => $id,
                'nama' => $request->nama,
                'username' => $request->username,
                'hp' => $hp,
                'id_jabatan' => $request->id_jabatan,
                'status' => $request->status ?: 'Y',
                'password' => Hash::make($request->password),
                'alamat' => $request->alamat,
                'rw_tugas' => $rw,
                'rt_tugas' => $rt,
                'id_buat' => $creatorId,
                'is_logged_in' => false,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Pengguna baru berhasil ditambahkan',
                'data' => [
                    'id' => (string) $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'id_jabatan' => (string) $user->id_jabatan,
                    'rw_tugas' => $user->rw_tugas,
                    'rt_tugas' => $user->rt_tugas,
                ],
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menambahkan pengguna: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Update existing user.
     */
    public function update(Request $request, $id)
    {
        try {
            $user = User::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nama' => 'required|string|max:100',
                'username' => 'required|string|max:100|unique:user,username,' . $id . ',id',
                'password' => 'nullable|string|min:4',
                'id_jabatan' => 'required|string|max:10',
                'status' => 'nullable|string|in:Y,N',
                'hp' => 'nullable|string|max:50',
                'alamat' => 'nullable|string',
                'rw_tugas' => 'nullable|string|max:10',
                'rt_tugas' => 'nullable|string|max:10',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => $validator->errors()->first(),
                ], 422);
            }

            $hp = $request->hp;
            if ($hp && Str::startsWith($hp, '08')) {
                $hp = '62' . substr($hp, 1);
            }

            $rw = $request->filled('rw_tugas') ? trim((string)$request->rw_tugas) : null;
            $rt = $request->filled('rt_tugas') ? trim((string)$request->rt_tugas) : null;
            if (empty($rw)) {
                $rw = null;
                $rt = null;
            }

            $user->nama = $request->nama;
            $user->username = $request->username;
            $user->hp = $hp;
            $user->id_jabatan = $request->id_jabatan;
            $user->status = $request->status ?: $user->status;
            $user->alamat = $request->alamat;
            $user->rw_tugas = $rw;
            $user->rt_tugas = $rt;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }

            if (Auth::check()) {
                $user->id_update = Auth::id();
            }

            $user->save();

            return response()->json([
                'status' => true,
                'message' => 'Data pengguna berhasil diperbarui',
                'data' => [
                    'id' => (string) $user->id,
                    'nama' => $user->nama,
                    'username' => $user->username,
                    'id_jabatan' => (string) $user->id_jabatan,
                    'rw_tugas' => $user->rw_tugas,
                    'rt_tugas' => $user->rt_tugas,
                ],
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal memperbarui pengguna: ' . $th->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete user.
     */
    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Prevent admin from deleting themselves
            if (Auth::check() && Auth::id() == $id) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak dapat menghapus akun Anda sendiri.',
                ], 400);
            }

            $user->is_logged_in = false;
            $user->save();
            $user->delete();

            return response()->json([
                'status' => true,
                'message' => 'Pengguna berhasil dihapus',
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menghapus pengguna: ' . $th->getMessage(),
            ], 500);
        }
    }
}
