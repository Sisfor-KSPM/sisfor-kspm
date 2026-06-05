<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UPengaturanController extends Controller
{
    // Menampilkan halaman pengaturan
    public function index()
    {
        return view('user.pengaturan');
    }

    // Memproses update data pengaturan
    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = auth()->user();

        // 1. Validasi Input
        $request->validate([
            'name' => 'required|string|max:255',
            // Pengecekan unique mengabaikan data milik user ini sendiri
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            // 'nullable' berarti field ini BOLEH KOSONG. Tapi jika diisi, wajib minimal 8 karakter & dikonfirmasi
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // 2. Timpa data dasar dengan data dari form
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // 3. Pengecualian Password: Cek apakah field password diisi.
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // 4. Simpan ke database
        $user->save();

        // 5. Kembalikan ke halaman pengaturan dengan pesan sukses
        return back()->with('success', 'Data akun berhasil diperbarui!');
    }
}