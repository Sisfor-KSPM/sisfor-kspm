<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\homecontent;
use App\Services\AnalyticsService;

class HomeContentController extends Controller
{
    public function index()
    {
        $home = Homecontent::first();
        if (!$home) {
            $home = Homecontent::create(['tagline' => '', 'judul' => '', 'deskripsi' => '', 'gambar_home' => '']);
        }
        return view('admin.home_content', compact('home'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'tagline' => 'required|string|max:255',
            'judul' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'ig_link' => 'nullable|url',
            'yt_link' => 'nullable|url',
            'linkedin_link' => 'nullable|url',
            'tt_link' => 'nullable|url',
            'email' => 'nullable|email',
            'whatsapp' => 'nullable|string|max:30',
        ]);

        $home = Homecontent::first();

        $home->update([
            'tagline' => $request->tagline,
            'judul' => $request->judul,
            'deskripsi' => $request->deskripsi,
            'ig_link' => $request->ig_link,
            'yt_link' => $request->yt_link,
            'linkedin_link' => $request->linkedin_link,
            'tt_link' => $request->tt_link,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
        ]);

        AnalyticsService::logActivity(auth()->id(), 'homecontent_update', "Beranda: {$home->judul}", [
            'target_type' => homecontent::class,
            'target_id' => $home->id,
            'action' => 'update'
        ]);

        return back()->with('success', 'Home content berhasil diperbarui.');
    }
}