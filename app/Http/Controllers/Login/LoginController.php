<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLogin()
    {
        return view('pages.login'); // menampilkan Blade login kamu
    }

    public function login(Request $request)
    {
        $isWebRequest = !$request->expectsJson();

        $validator = Validator::make($request->all(), [
            "username" => "required",
            "password" => "required",
        ]);

        if ($validator->fails()) {
            if ($isWebRequest) {
                return back()->withErrors($validator)->withInput();
            }
            return response()->json([
                "status" => false,
                "message" => $validator->errors()->first()
            ], 401);
        }

        $user = User::where("username", $request->username)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            $errorMsg = 'Username atau password salah.';
            return $isWebRequest
                ? back()->withErrors(['username' => $errorMsg])->withInput()
                : response()->json(['status' => false, 'message' => $errorMsg], 401);
        }

        if (!$user->jabatan || strtolower($user->jabatan->nama_jabatan) !== 'admin') {
            $errorMsg = 'Akses ditolak. Hanya admin yang dapat login.';
            return $isWebRequest
                ? back()->withErrors(['username' => $errorMsg])->withInput()
                : response()->json(['status' => false, 'message' => $errorMsg], 403);
        }

        if ($user->status === 'N') {
            $errorMsg = 'Akun Anda tidak aktif. Hubungi admin.';
            return $isWebRequest
                ? back()->withErrors(['username' => $errorMsg])->withInput()
                : response()->json(['status' => false, 'message' => $errorMsg], 403);
        }

        // 🚫 Cek apakah user sudah login di tempat lain
        // if ($user->is_logged_in) {
        //     $errorMsg = 'Akun ini sedang aktif di perangkat lain.';
        //     return $isWebRequest
        //         ? back()->withErrors(['username' => $errorMsg])->withInput()
        //         : response()->json(['status' => false, 'message' => $errorMsg], 403);
        // }

        // ✅ Tandai user sudah login
        $user->is_logged_in = true;
        $user->save();

        if ($isWebRequest) {
            Auth::login($user, true);
            return redirect()->intended('/dashboard');
        }

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
            ]
        ]);
    }


    public function getdatauser()
    {
        $userData = Auth::user();
        return response()->json([
            "status" => true,
            "message" => "Data User",
            "data" => $userData
        ]);
    }
    public function logout(Request $request)
    {
        if ($request->expectsJson()) {
            // Logout dari API
            $user = $request->user();
            $user->tokens()->delete();
            $user->is_logged_in = false;
            $user->save();

            return response()->json([
                "status" => true,
                "message" => "Berhasil Logout"
            ]);
        }

        // Logout dari web
        $user = Auth::user();
        if ($user) {
            $user->is_logged_in = false;
            $user->save();
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'Anda telah logout.');
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
