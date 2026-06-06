<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Simpan user ke database
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Password otomatis di-hash
        ]);

        // 3. Kembalikan response JSON
        return response()->json([
            'status' => 'success',
            'message' => 'User berhasil didaftarkan',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        // 1. Validasi input (menggunakan nama field 'login' untuk menerima email/username)
        $validator = Validator::make($request->all(), [
            'login' => 'required|string', 
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // 2. Cek apakah input berupa format email yang valid atau bukan
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Cari user di database berdasarkan email atau username
        $user = User::where($loginType, $request->login)->first();

        // 4. Jika user tidak ditemukan ATAU password salah
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email/Username atau Password salah!'
            ], 401);
        }

        // 5. Buat token akses untuk user
        $token = $user->createToken('auth_token')->plainTextToken;

        // 6. Kembalikan response sukses beserta tokennya
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }

    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string', 
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validator->errors()
            ], 422);
        }

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($loginType, $request->login)->first();

        // Pengecekan ekstra: Pastikan user ditemukan, password cocok, DAN rolenya adalah 'admin'
        if (!$user || !Hash::check($request->password, $user->password) || $user->role !== 'admin') {
            return response()->json([
                'status' => 'error',
                'message' => 'Akses ditolak! Kredensial salah atau Anda bukan Admin.'
            ], 401);
        }

        // Buat token khusus admin
        $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Admin Login berhasil',
            'data' => $user,
            'access_token' => $token,
            'token_type' => 'Bearer'
        ], 200);
    }
}