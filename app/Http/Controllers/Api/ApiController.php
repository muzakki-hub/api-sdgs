<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
    public function showLogin()
    {
        return view('pages.login'); // menampilkan Blade login kamu
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            // "id" => "required|string",
            "nama" => "required|string",
            "username" => "required|string",
            "hp" => "required|string",
            "id_jabatan" => "required|string",
            "status" => "required|string",
            "password" => "required|confirmed",
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            $response = [
                "status" => false,
                "message" => $errorMessage,
            ];
            return response()->json($response, 401);
        }

        $id = strtotime(date("Y-m-d H:i:s"));
        User::create([
            "id" => $id,
            "nama" => $request->nama,
            "username" => $request->username,
            "hp" => $request->hp,
            "id_jabatan" => $request->id_jabatan,
            "status" => $request->status,
            "password" => bcrypt($request->password),
            "alamat" => $request->alamat,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Berhasil Daftar"
        ]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            $errorMessage = $validator->errors()->first();
            return response()->json([
                "status" => false,
                "message" => $errorMessage,
            ], 401);
        }

        $user = User::where("username", $request->username)->first();

        if (empty($user)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Login",
            ]);
        }

        // Cek password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                "status" => false,
                "message" => "Invalid Login! Password Salah",
            ]);
        }

        // 🔥 Cek status
        if ($user->status === 'N') {
            return response()->json([
                "status" => false,
                "message" => "Akun Anda tidak aktif. Hubungi admin.",
            ], 403);
        }

        // if ($user->is_logged_in) {
        //     return response()->json([
        //         "status" => false,
        //         "message" => "User ini sudah login di perangkat lain.",
        //     ], 403);
        // }

        // 🔥 Set user sebagai sedang login
        $user->is_logged_in = true;
        $user->save();

        $token = $user->createToken("adminbaru2")->plainTextToken;
        return response()->json([
            "status" => true,
            "message" => "Login Berhasil",
            "token" => $token,
            "user" => [
                "id" => $user->id,
                "username" => $user->username,
                "hp" => $user->hp,
                "email" => $user->email ?? null,
                "nama" => $user->nama ?? null,
                "id_jabatan" => $user->id_jabatan,
                "jabatan" => $user->jabatan ? $user->jabatan->nama_jabatan : null,
                "rw_tugas" => $user->rw_tugas ? (string)$user->rw_tugas : null,
                "rt_tugas" => $user->rt_tugas ? (string)$user->rt_tugas : null,
                "status" => $user->status,
                "alamat" => $user->alamat,
                "tanda_tangan" => $user->tanda_tangan ? asset($user->tanda_tangan) : null,
            ]
        ]);
    }


    public function getdatauser()
    {
             try {
            $userData = Auth::user()->load('jabatan');

            return response()->json([
                "status" => true,
                "message" => "Data User",
                "data" => $userData,
            'nama_jabatan' => optional($userData->jabatan)->nama_jabatan,
            ], 200);
        } catch (\Throwable $th) {

            return response()->json([
                "status" => false,
                "message" => "Terjadi kesalahan saat mengambil data user",
                "error" => $th->getMessage(),
                "line" => $th->getLine(),
                "file" => $th->getFile()
            ], 500);
        }
    }

    public function logout(Request $request)
    {
        $user = $request->user();

        // Hapus semua token aktif user ini
        $user->tokens()->delete();

        // Tandai sudah logout
        $user->is_logged_in = false;
        $user->save();

        return response()->json([
            "status" => true,
            "message" => "Berhasil Logout"
        ]);
    }

    public function refreshToken()
    {
        $tokenInfo = request()->user()->createToken("tokenbaru-admin");
        $newToken = $tokenInfo->plainTextToken;
        return response()->json([
            "status" => true,
            "message" => "Token Diperbarui",
            "access_token" => $newToken
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = $request->user() ?? auth('sanctum')->user() ?? Auth::user();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'Unauthenticated',
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'nullable|string|max:255',
            'hp' => 'sometimes|nullable|string|max:50',
            'alamat' => 'sometimes|nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors(),
            ], 422);
        }

        if (empty($user->tanda_tangan) && !$request->filled('tanda_tangan') && !$request->hasFile('tanda_tangan_file')) {
            return response()->json([
                'status' => false,
                'message' => 'Tanda tangan digital wajib dibuat atau diunggah.',
                'errors' => ['tanda_tangan' => ['Tanda tangan digital wajib dibuat atau diunggah.']],
            ], 422);
        }

        if ($request->filled('nama')) {
            $user->nama = trim($request->nama);
        }
        if ($request->filled('hp')) {
            $user->hp = trim($request->hp);
        }
        if ($request->filled('alamat')) {
            $user->alamat = trim($request->alamat);
        }

        // Handle tanda tangan digital (base64 dari canvas atau upload file)
        if ($request->filled('tanda_tangan')) {
            $ttdData = $request->tanda_tangan;
            if (preg_match('/^data:image\/(\w+);base64,/', $ttdData, $type)) {
                $ttdData = substr($ttdData, strpos($ttdData, ',') + 1);
                $ttdDecoded = base64_decode($ttdData);
                if ($ttdDecoded !== false) {
                    $dir = public_path('uploads/ttd');
                    if (!file_exists($dir)) {
                        mkdir($dir, 0775, true);
                    }
                    $filename = 'ttd_' . $user->id . '_' . time() . '.png';
                    file_put_contents($dir . '/' . $filename, $ttdDecoded);
                    $user->tanda_tangan = 'uploads/ttd/' . $filename;
                }
            }
        } elseif ($request->hasFile('tanda_tangan_file')) {
            $file = $request->file('tanda_tangan_file');
            $dir = public_path('uploads/ttd');
            if (!file_exists($dir)) {
                mkdir($dir, 0775, true);
            }
            $filename = 'ttd_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $user->tanda_tangan = 'uploads/ttd/' . $filename;
        }

        $user->save();

        // Reload relasi jabatan
        $userData = $user->load('jabatan');

        return response()->json([
            'status' => true,
            'message' => 'Profil berhasil diperbarui.',
            'data' => $userData,
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'hp' => $user->hp,
                'email' => $user->email ?? null,
                'nama' => $user->nama ?? null,
                'jabatan' => $user->jabatan ? $user->jabatan->nama_jabatan : null,
                'status' => $user->status,
                'alamat' => $user->alamat,
                'tanda_tangan' => $user->tanda_tangan ? asset($user->tanda_tangan) : null,
            ],
            'nama_jabatan' => optional($userData->jabatan)->nama_jabatan,
        ], 200);
    }
}
