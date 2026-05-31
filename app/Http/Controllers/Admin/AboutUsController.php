<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\DataPengurus;

class AboutUsController extends Controller
{
    public function index()
    {
        // Ambil baris pertama, jika tidak ada kirim objek kosong
        $about = AboutUs::first() ?? new AboutUs();
        $pengurus = DataPengurus::latest()->get();
        return view('admin.about_us.edit', compact('about', 'pengurus'));
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

    /**
     * Simpan pengurus baru
     */
    public function pengurus_store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'periode' => 'required|string|max:50',
            'angkatan' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'foto_pengurus' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($request->hasFile('foto_pengurus')) {
            $validated['foto_pengurus'] = $request
                ->file('foto_pengurus')
                ->store('pengurus', 'public');
        }

        DataPengurus::create($validated);

        return back()->with('success', 'Pengurus berhasil ditambahkan.');
    }

    /**
     * Ambil data untuk edit (AJAX)
     */
    public function pengurus_edit($id)
    {
        $pengurus = DataPengurus::findOrFail($id);

        return response()->json($pengurus);
    }

    /**
     * Update data
     */
    public function pengurus_update(Request $request, $id)
    {
        $pengurus = DataPengurus::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'nim' => 'nullable|string|max:50',
            'jabatan' => 'required|string|max:255',
            'divisi' => 'required|string|max:255',
            'periode' => 'required|string|max:50',
            'angkatan' => 'nullable|string|max:20',
            'email' => 'nullable|string|max:255',
            'linkedin' => 'nullable|string|max:255',
            'foto_pengurus' => 'nullable|image|mimes:jpg,jpeg,png|max:1024',
        ]);

        if ($request->hasFile('foto_pengurus')) {

            if (
                $pengurus->foto_pengurus &&
                Storage::disk('public')->exists($pengurus->foto_pengurus)
            ) {
                Storage::disk('public')->delete($pengurus->foto_pengurus);
            }

            $validated['foto_pengurus'] = $request
                ->file('foto_pengurus')
                ->store('pengurus', 'public');
        }

        $pengurus->update($validated);

        return back()->with('success', 'Pengurus berhasil diperbarui.');
    }

    /**
     * Hapus data
     */
    public function pengurus_destroy($id)
    {
        $pengurus = DataPengurus::findOrFail($id);

        if (
            $pengurus->foto_pengurus &&
            Storage::disk('public')->exists($pengurus->foto_pengurus)
        ) {
            Storage::disk('public')->delete($pengurus->foto_pengurus);
        }

        $pengurus->delete();

        return back()->with('success', 'Pengurus berhasil dihapus.');
    }
}