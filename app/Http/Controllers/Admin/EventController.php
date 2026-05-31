<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
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

        Event::create($validated);
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
        return back()->with('success', 'Kegiatan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        Event::findOrFail($id)->delete();
        return back()->with('success', 'Kegiatan berhasil dihapus!');
    }
}