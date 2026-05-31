<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dictionary;
use Illuminate\Http\Request;

class DictionaryController extends Controller
{
    // ================= FUNGSI WEB (ADMIN) =================
    public function index(Request $request)
    {
        // Fitur pencarian di sisi admin
        $search = $request->input('search');
        
        $terms = Dictionary::orderBy('istilah', 'asc')
            ->when($search, function ($query, $search) {
                return $query->where('istilah', 'like', "%{$search}%")
                             ->orWhere('definisi', 'like', "%{$search}%");
            })
            ->get();

        return view('admin.kamus', compact('terms', 'search'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'istilah'  => 'required|string|max:255',
            'definisi' => 'required|string',
            'kategori' => 'required|string',
        ]);

        Dictionary::create($request->only(['istilah', 'definisi', 'kategori']));
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
        
        return back()->with('success', 'Istilah berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $term = Dictionary::findOrFail($id);
        $term->delete();
        return back()->with('success', 'Istilah berhasil dihapus!');
    }
}