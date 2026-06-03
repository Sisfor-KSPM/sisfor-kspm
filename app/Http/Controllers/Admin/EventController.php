<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        // [ANALYTICS] Track akses halaman manajemen event
        AnalyticsService::trackFeatureUsage('admin_event_page');
        
        $events = Event::orderBy('tanggal', 'desc')->get();
        return view('admin.kegiatan', compact('events'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tipe' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:upcoming,berlangsung,selesai,dibatalkan',
            'kuota' => 'nullable|string|max:100',
        ]);

        $event = Event::create($validated);
        
        // [ANALYTICS] Track pembuatan event baru
        AnalyticsService::logActivity(auth()->id(), 'event_create', "Event: {$validated['kegiatan']}");
        
        return back()->with('success', 'Kegiatan berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $event = Event::findOrFail($id);
        return response()->json($event);
    }

    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);
        
        $validated = $request->validate([
            'kegiatan' => 'required|string|max:255',
            'tipe' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'tempat' => 'nullable|string|max:255',
            'pic' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:upcoming,berlangsung,selesai,dibatalkan',
            'kuota' => 'nullable|string|max:100',
        ]);

        $event->update($validated);
        
        // [ANALYTICS] Track perubahan event
        AnalyticsService::logActivity(auth()->id(), 'event_update', "Event: {$validated['kegiatan']}");
        
        return back()->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        // [ANALYTICS] Track penghapusan event
        AnalyticsService::logActivity(auth()->id(), 'event_delete', "Event: {$event->kegiatan}");
        
        $event->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}