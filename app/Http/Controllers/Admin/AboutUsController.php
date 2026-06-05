<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AboutUs;
use App\Models\DataPengurus;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutUsController extends Controller
{
    public function index()
    {
        $about = AboutUs::first() ?? new AboutUs();
        $pengurus = DataPengurus::latest()->get();
        return view('admin.about_us.edit', compact('about', 'pengurus'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'singkatan' => 'nullable|string|max:50',
            'kepanjangan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'visi' => 'nullable|string',
            'misi' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:2048',
            'tahun_berdiri' => 'nullable|string|max:50',
            'total_anggota' => 'nullable|string|max:50',
            'tahun_aktif' => 'nullable|string|max:50',
            'program_kerja' => 'nullable|string|max:50',
            'publikasi_riset' => 'nullable|string|max:50',
        ]);

        $about = AboutUs::first() ?? new AboutUs();

        if ($request->hasFile('logo')) {
            if ($about->logo && Storage::disk('public')->exists($about->logo)) {
                Storage::disk('public')->delete($about->logo);
            }
            $validated['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $about->fill($validated);
        $about->save();

        AnalyticsService::logActivity(auth()->id(), 'aboutus_update', "Profil: {$about->nama}", [
            'target_type' => AboutUs::class,
            'target_id' => $about->id,
            'action' => 'update'
        ]);

        return back()->with('success', 'Konten About Us berhasil diperbarui!');
    }

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
            $validated['foto_pengurus'] = $request->file('foto_pengurus')->store('pengurus', 'public');
        }

        $pengurus = DataPengurus::create($validated);

        AnalyticsService::logActivity(auth()->id(), 'pengurus_create', "Pengurus: {$pengurus->nama}", [
            'target_type' => DataPengurus::class,
            'target_id' => $pengurus->id,
            'action' => 'create'
        ]);

        return back()->with('success', 'Pengurus berhasil ditambahkan.');
    }

    public function pengurus_edit($id)
    {
        $pengurus = DataPengurus::findOrFail($id);
        return response()->json($pengurus);
    }

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
            if ($pengurus->foto_pengurus && Storage::disk('public')->exists($pengurus->foto_pengurus)) {
                Storage::disk('public')->delete($pengurus->foto_pengurus);
            }
            $validated['foto_pengurus'] = $request->file('foto_pengurus')->store('pengurus', 'public');
        } else {
            unset($validated['foto_pengurus']);
        }

        $pengurus->update($validated);

        AnalyticsService::logActivity(auth()->id(), 'pengurus_update', "Pengurus: {$pengurus->nama}", [
            'target_type' => DataPengurus::class,
            'target_id' => $pengurus->id,
            'action' => 'update'
        ]);

        return back()->with('success', 'Data & Foto Pengurus berhasil diperbarui.');
    }

    public function pengurus_destroy($id)
    {
        $pengurus = DataPengurus::findOrFail($id);

        AnalyticsService::logActivity(auth()->id(), 'pengurus_delete', "Pengurus: {$pengurus->nama}", [
            'action' => 'delete'
        ]);

        if ($pengurus->foto_pengurus && Storage::disk('public')->exists($pengurus->foto_pengurus)) {
            Storage::disk('public')->delete($pengurus->foto_pengurus);
        }

        $pengurus->delete();

        return back()->with('success', 'Pengurus berhasil dihapus.');
    }
}