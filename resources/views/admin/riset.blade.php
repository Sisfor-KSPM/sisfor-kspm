@extends('layouts.admin')

@section('page-title', 'Riset & Publikasi')
@section('page-breadcrumb', 'Manajemen Dokumen')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Riset & Publikasi</div>
        <div class="section-sub text-sm text-gray-500">Kelola dokumen riset KSPM</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <div class="search-bar relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input class="inp inp-sm pl-9" placeholder="Cari riset...">
        </div>
        <select class="inp inp-sm" style="width:auto">
            <option value="">Semua Kategori</option>
            <option>Weekly Outlook</option>
            <option>Analisis Fundamental</option>
            <option>Stock Pick</option>
            <option>Outlook Sektor</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-riset').classList.add('open')">+ Upload Riset</button>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reports as $report)
                    <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                                <a href="{{ asset($report->pdf_file) }}" download class="font-semibold text-[0.85rem] text-gray-900 hover:text-blue-600">{{ $report->judul_riset }}</a>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">{{ ucfirst($report->kategori) }}</span></td>
                        <td class="px-4 py-3 text-[0.82rem] text-gray-900">{{ $report->penulis ?: '-' }}</td>
                        <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">{{ $report->tanggal_rilis ?: '-' }}</td>
                        <td class="px-4 py-3"><span class="bg-{{ $report->status === 'publik' ? 'green' : ($report->status === 'draft' ? 'orange' : 'gray') }}-100 text-{{ $report->status === 'publik' ? 'green' : ($report->status === 'draft' ? 'orange' : 'gray') }}-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">{{ ucfirst($report->status) }}</span></td>
                        <td class="px-4 py-3 text-right">
                            <form action="{{ route('admin.riset.destroy', $report->id) }}" method="POST" onsubmit="return confirm('Hapus laporan ini?');" style="display:inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada laporan riset.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL UPLOAD RISET -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-riset">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <form action="{{ route('admin.riset.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
                <div class="modal-title text-base font-bold text-gray-900">Upload Riset</div>
                <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-riset').classList.remove('open')">✕</button>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Riset*</label>
                <input type="text" name="judul_riset" class="inp" placeholder="Judul dokumen riset" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Singkat</label>
                <input type="text" name="deskripsi_singkat" class="inp" placeholder="Deskripsi singkat laporan">
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori*</label>
                    <select name="kategori" class="inp" required>
                        <option value="">Pilih kategori</option>
                        <option value="weekly">Weekly Outlook</option>
                        <option value="fundamental">Analisis Fundamental</option>
                        <option value="stock">Stock Pick</option>
                        <option value="outlook">Outlook Sektor</option>
                        <option value="khusus">Riset Khusus</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Penulis</label>
                    <input type="text" name="penulis" class="inp" placeholder="Nama / Divisi">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Rilis</label><input type="date" name="tanggal_rilis" class="inp"></div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Status Publikasi</label>
                    <select name="status" class="inp" required>
                        <option value="publik">Publik</option>
                        <option value="draft">Draft</option>
                        <option value="terbatas">Terbatas</option>
                    </select>
                </div>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">📄 Upload PDF*</label>
                <input type="file" name="pdf_file" accept=".pdf" class="w-full rounded-xl border border-gray-300 p-3" required>
                <p class="text-[0.75rem] text-gray-400 mt-2">File PDF hingga 10MB</p>
            </div>
            
            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-riset').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">📊 Simpan</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }
</style>
@endpush