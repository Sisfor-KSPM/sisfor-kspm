<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Header;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeaderController extends Controller
{
    public function edit()
    {
        $header = Header::first() ?? new Header();
        return view('admin.header.edit', compact('header'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'welcome_banner' => 'required|string|max:255',
            'tagline' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $header = Header::first() ?? new Header();
        $header->welcome_banner = $request->welcome_banner;
        $header->tagline = $request->tagline;

        if ($request->hasFile('main_image')) {
            if ($header->main_image && Storage::exists('public/' . $header->main_image)) Storage::delete('public/' . $header->main_image);
            $header->main_image = $request->file('main_image')->store('headers', 'public');
        }

        $header->save();

        AnalyticsService::logActivity(auth()->id(), 'header_update', "Header: {$header->welcome_banner}", [
            'target_type' => Header::class,
            'target_id' => $header->id,
            'action' => 'update'
        ]);

        return back()->with('success', 'Header berhasil diperbarui!');
    }

    public function updateApi(Request $request)
    {
        $request->validate([
            'welcome_banner' => 'required|string|max:255',
            'tagline' => 'required|string',
            'main_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $header = Header::first() ?? new Header();
        $header->welcome_banner = $request->welcome_banner;
        $header->tagline = $request->tagline;

        if ($request->hasFile('main_image')) {
            if ($header->main_image && Storage::exists('public/' . $header->main_image)) Storage::delete('public/' . $header->main_image);
            $header->main_image = $request->file('main_image')->store('headers', 'public');
        }

        $header->save();

        AnalyticsService::logActivity(auth()->id(), 'header_update', "Header: {$header->welcome_banner}", [
            'target_type' => Header::class,
            'target_id' => $header->id,
            'action' => 'update'
        ]);

        return response()->json(['status' => 'success', 'message' => 'Header berhasil diperbarui via API!', 'data' => $header], 200);
    }
}