<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReportController extends Controller
{
    public function index()
    {
        // [ANALYTICS] Track akses halaman manajemen riset
        AnalyticsService::trackFeatureUsage('admin_report_page');
        
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('admin.riset', compact('reports'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul_riset' => 'required|string|max:255',
            'deskripsi_singkat' => 'nullable|string|max:255',
            'kategori' => 'required|string|max:100',
            'penulis' => 'nullable|string|max:255',
            'tanggal_rilis' => 'nullable|date',
            'pdf_file' => 'required|mimes:pdf|max:10240',
            'status' => 'required|in:publik,draft,terbatas',
        ]);

        $file = $request->file('pdf_file');
        $destination = public_path('reports');
        if (!File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($destination, $filename);

        $validated['pdf_file'] = 'reports/' . $filename;

        $report = Report::create($validated);
        
        // [ANALYTICS] Track pengunggahan laporan baru
        AnalyticsService::logActivity(auth()->id(), 'report_upload', "Report: {$validated['judul_riset']}");

        return back()->with('success', 'Riset berhasil diupload.');
    }

    public function destroy($id)
    {
        $report = Report::findOrFail($id);

        if ($report->pdf_file && File::exists(public_path($report->pdf_file))) {
            File::delete(public_path($report->pdf_file));
        }

        // [ANALYTICS] Track penghapusan laporan
        AnalyticsService::logActivity(auth()->id(), 'report_delete', "Report: {$report->judul_riset}");

        $report->delete();

        return back()->with('success', 'Riset berhasil dihapus.');
    }
}