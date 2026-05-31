<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    // Tampil di halaman Admin
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq', compact('faqs')); // Sesuaikan dengan folder view admin Anda
    }

    // Simpan Data Baru
    public function store(Request $request)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        Faq::create($request->all());

        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    // Update Data
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string',
            'jawaban' => 'required|string',
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        return redirect()->back()->with('success', 'FAQ berhasil diperbarui!');
    }

    // Hapus Data
    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();

        return redirect()->back()->with('success', 'FAQ berhasil dihapus!');
    }
}
