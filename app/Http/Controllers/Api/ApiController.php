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
                "jabatan" => $user->jabatan ? $user->jabatan->nama_jabatan : null,
                "status" => $user->status,
                "alamat" => $user->alamat,
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
}
