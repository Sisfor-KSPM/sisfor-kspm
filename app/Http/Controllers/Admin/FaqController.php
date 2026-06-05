<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::latest()->get();
        return view('admin.faq', compact('faqs')); 
    }

    public function store(Request $request)
    {
        $request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']);

        $faq = Faq::create($request->all());

        AnalyticsService::logActivity(auth()->id(), 'faq_create', "FAQ: {$faq->pertanyaan}", [
            'target_type' => Faq::class,
            'target_id' => $faq->id,
            'action' => 'create'
        ]);

        return redirect()->back()->with('success', 'FAQ berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate(['pertanyaan' => 'required|string', 'jawaban' => 'required|string']);

        $faq = Faq::findOrFail($id);
        $faq->update($request->all());

        AnalyticsService::logActivity(auth()->id(), 'faq_update', "FAQ: {$faq->pertanyaan}", [
            'target_type' => Faq::class,
            'target_id' => $faq->id,
            'action' => 'update'
        ]);

        return redirect()->back()->with('success', 'FAQ berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $faq = Faq::findOrFail($id);

        AnalyticsService::logActivity(auth()->id(), 'faq_delete', "FAQ: {$faq->pertanyaan}", [
            'action' => 'delete'
        ]);

        $faq->delete();
        return redirect()->back()->with('success', 'FAQ berhasil dihapus!');
    }
}