<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $terms = Dictionary::orderBy('istilah', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('istilah', 'like', "%{$search}%")
                             ->orWhere('definisi', 'like', "%{$search}%");
            })->get();

        return view('admin.kamus', compact('terms', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'istilah'  => 'required|string|max:255',
            'definisi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $term = Dictionary::create($request->only(['istilah', 'definisi', 'kategori']));
        
        AnalyticsService::logActivity(auth()->id(), 'dictionary_create', "Kamus: {$term->istilah}", [
            'target_type' => Dictionary::class,
            'target_id' => $term->id,
            'action' => 'create'
        ]);

        return back()->with('success', 'Istilah baru berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'istilah'  => 'required|string|max:255',
            'definisi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        $term = Dictionary::findOrFail($id);
        $term->update($request->only(['istilah', 'definisi', 'kategori']));
        
        AnalyticsService::logActivity(auth()->id(), 'dictionary_update', "Kamus: {$term->istilah}", [
            'target_type' => Dictionary::class,
            'target_id' => $term->id,
            'action' => 'update'
        ]);
        
        return back()->with('success', 'Istilah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $term = Dictionary::findOrFail($id);
        
        AnalyticsService::logActivity(auth()->id(), 'dictionary_delete', "Kamus: {$term->istilah}", [
            'action' => 'delete'
        ]);

        $term->delete();
        return back()->with('success', 'Istilah berhasil dihapus!');
    }
}