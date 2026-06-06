<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // 1. Validasi input
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role'     => 'required|in:ipb,umum',  // Validasi bawaan dari form tetap dibiarkan
        ]);

        // Jika validasi gagal, kembali ke halaman form dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput($request->except('password', 'password_confirmation'));
        }

        // 2. PENGECEKAN DOMAIN EMAIL (Otomatisasi Role)
        // Mengecek apakah email diakhiri dengan tepat '@apps.ipb.ac.id'
        $finalRole = str_ends_with($request->email, '@apps.ipb.ac.id') ? 'ipb' : 'umum';

        // 3. Simpan user ke database
        $user = User::create([
            'name'     => $request->name,
            'username' => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $finalRole,  // Menyimpan role hasil pengecekan email, bukan dari form
        ]);

        // 4. Alihkan ke login dengan pesan sukses
        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan masuk menggunakan akun Anda.');
    }

    public function login(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'login'    => 'required|string',
            'password' => 'required|string',
        ]);

        // 2. Cek apakah input berupa email atau username
        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        // 3. Siapkan kredensial
        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        // 4. Lakukan percobaan login menggunakan Session
        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('user.dashboard'))
                             ->with('success', 'Login berhasil!');
        }

        // 5. Jika login gagal
        return back()->withErrors([
            'login' => 'Email/Username atau Password salah!',
        ])->onlyInput('login');
    }

    public function loginAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login'    => 'required|string',
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

        // Pastikan user ditemukan, password cocok, DAN rolenya adalah 'admin'
        if (!$user || !Hash::check($request->password, $user->password) || $user->role !== 'admin') {
            return response()->json([
                'status'  => 'error',
                'message' => 'Akses ditolak! Kredensial salah atau Anda bukan Admin.'
            ], 401);
        }

        // Buat token khusus admin
        $token = $user->createToken('admin_token')->plainTextToken;

        return response()->json([
            'status'       => 'success',
            'message'      => 'Admin Login berhasil',
            'data'         => $user,
            'access_token' => $token,
            'token_type'   => 'Bearer'
        ], 200);
    }
}