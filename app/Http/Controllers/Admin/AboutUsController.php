<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;

class AboutUsController extends Controller
{
    public function index()
    {
        // Ambil baris pertama, jika tidak ada kirim objek kosong
        $about = AboutUs::first() ?? new AboutUs();
        return view('admin.about_us.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'kepanjangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048', // Batas upload 2MB
            'tahun_berdiri' => 'nullable|string|max:50',
            'total_anggota' => 'nullable|string|max:50',
            'tahun_aktif' => 'nullable|string|max:50',
            'program_kerja' => 'nullable|string|max:50',
            'publikasi_riset' => 'nullable|string|max:50',
        ]);

        // Cari data pertama, atau buat instance baru jika tabel kosong
        $about = AboutUs::first() ?? new AboutUs();

        // Ambil semua data input kecuali file logo terlebih dahulu
        $data = $request->except('logo');

        // Logika Upload Logo Utama
        if ($request->hasFile('logo')) {
            // Jika data lama sudah ada logonya, hapus file lamanya biar memori gak penuh
            if ($about->logo && Storage::disk('public')->exists($about->logo)) {
                Storage::disk('public')->delete($about->logo);
            }

            // Simpan gambar baru ke folder storage/app/public/logos
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        // Simpan perubahan ke database
        $about->fill($data);
        $about->save();

        return back()->with('success', 'Konten About Us berhasil diperbarui!');
    }
}