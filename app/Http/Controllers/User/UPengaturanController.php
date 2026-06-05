<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'cropped_profile_photo' => 'nullable|string',
            'remove_profile_photo' => 'nullable|boolean',
        ]);

        // 2. Timpa data dasar dengan data dari form
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;

        // 3. Pengecualian Password: Cek apakah field password diisi.
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->boolean('remove_profile_photo') && $user->profile_photo) {
            Storage::disk('public')->delete($user->profile_photo);
            $user->profile_photo = null;
        }

        if ($request->filled('cropped_profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $this->storeCroppedProfilePhoto($request->input('cropped_profile_photo'));
        } elseif ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                Storage::disk('public')->delete($user->profile_photo);
            }

            $user->profile_photo = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        // 4. Simpan ke database
        $user->save();

        // 5. Kembalikan ke halaman pengaturan dengan pesan sukses
        return back()->with('success', 'Data akun berhasil diperbarui!');
    }

    private function storeCroppedProfilePhoto(string $dataUrl): string
    {
        abort_unless(preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $dataUrl), 422, 'Format crop foto tidak valid.');

        $imageData = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);
        abort_unless($imageData !== false, 422, 'Data crop foto tidak valid.');

        $path = 'profile-photos/' . Str::uuid() . '.jpg';
        Storage::disk('public')->put($path, $imageData);

        return $path;
    }
}
