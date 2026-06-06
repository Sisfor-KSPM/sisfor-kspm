<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('admin.gallery', compact('galleries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'foto_base64' => 'required|string',   // base64 hasil crop dari frontend
            'judul'       => 'required|string|max:255',
            'kategori'    => 'required|string|max:100',
            'tanggal'     => 'nullable|date',
            'fotografer'  => 'nullable|string|max:255',
            'homepage'    => 'required|in:ya,tidak',
        ]);

        // Decode base64 → simpan sebagai file JPEG
        $base64 = $request->input('foto_base64');
        if (!preg_match('/^data:image\/(jpeg|jpg|png|webp);base64,/', $base64)) {
            return back()->withErrors(['foto_base64' => 'Format foto tidak valid.'])->withInput();
        }

        $imageData   = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $base64));
        $destination = public_path('gallery-uploads');
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.jpg';
        File::put($destination . '/' . $filename, $imageData);

        unset($validated['foto_base64']);
        $validated['foto_link'] = 'gallery-uploads/' . $filename;

        $gallery = Gallery::create($validated);

        AnalyticsService::logActivity(auth()->id(), 'gallery_create', "Galeri: {$gallery->judul}", [
            'target_type' => Gallery::class,
            'target_id'   => $gallery->id,
            'action'      => 'create',
        ]);

        return back()->with('success', 'Foto gallery berhasil diupload.');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        AnalyticsService::logActivity(auth()->id(), 'gallery_delete', "Galeri: {$gallery->judul}", [
            'action' => 'delete'
        ]);

        if ($gallery->foto_link && File::exists(public_path($gallery->foto_link))) {
            File::delete(public_path($gallery->foto_link));
        }

        $gallery->delete();

        return back()->with('success', 'Foto gallery berhasil dihapus.');
    }
}