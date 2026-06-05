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
        
        AnalyticsService::logActivity(auth()->id(), 'event_create', "Kegiatan: {$event->kegiatan}", [
            'target_type' => Event::class,
            'target_id' => $event->id,
            'action' => 'create'
        ]);
        
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
        
        AnalyticsService::logActivity(auth()->id(), 'event_update', "Kegiatan: {$event->kegiatan}", [
            'target_type' => Event::class,
            'target_id' => $event->id,
            'action' => 'update'
        ]);
        
        return back()->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $event = Event::findOrFail($id);
        
        AnalyticsService::logActivity(auth()->id(), 'event_delete', "Kegiatan: {$event->kegiatan}", [
            'action' => 'delete'
        ]);
        
        $event->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}