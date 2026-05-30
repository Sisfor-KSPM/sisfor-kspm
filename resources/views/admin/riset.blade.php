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
                    <th class="px-4 py-3">Ukuran</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Riset Row 1 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                            <div class="font-semibold text-[0.85rem] text-gray-900">Weekly Outlook Vol.11 — Feb 2025</div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Weekly Outlook</span></td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">KSPM Research Team</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-02-17</td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-700">2.1 MB</td>
                    <td class="px-4 py-3"><span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Publik</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
                
                <!-- Riset Row 2 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                            <div class="font-semibold text-[0.85rem] text-gray-900">Weekly Outlook Vol.10 — Feb 2025</div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Weekly Outlook</span></td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">KSPM Research Team</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-02-10</td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-700">1.9 MB</td>
                    <td class="px-4 py-3"><span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Publik</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
                
                <!-- Riset Row 3 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                            <div class="font-semibold text-[0.85rem] text-gray-900">Analisis Fundamental BBCA Q4 2024</div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-orange-100 text-orange-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Analisis Fundamental</span></td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">Divisi Riset</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-02-05</td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-700">1.5 MB</td>
                    <td class="px-4 py-3"><span class="bg-green-100 text-green-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Publik</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>

                <!-- Riset Row 4 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                            <div class="font-semibold text-[0.85rem] text-gray-900">Draft Analisis TLKM Q1 2025</div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-orange-100 text-orange-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">Analisis Fundamental</span></td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">Divisi Riset</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-03-10</td>
                    <td class="px-4 py-3 text-[0.82rem] text-gray-700">1.7 MB</td>
                    <td class="px-4 py-3"><span class="bg-orange-100 text-orange-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Draft</span></td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL UPLOAD RISET -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-riset">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900">Upload Riset</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-riset').classList.remove('open')">✕</button>
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Riset*</label>
            <input class="inp" placeholder="Judul dokumen riset">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori*</label>
                <select class="inp">
                    <option>Weekly Outlook</option><option>Analisis Fundamental</option>
                    <option>Stock Pick</option><option>Outlook Sektor</option><option>Riset Khusus</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Penulis</label>
                <input class="inp" placeholder="Nama / Divisi">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Rilis</label><input type="date" class="inp"></div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Status Publikasi</label>
                <select class="inp">
                    <option>Publik</option><option>Draft</option><option>Terbatas</option>
                </select>
            </div>
        </div>
        
        <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer mb-3.5" onclick="alert('Upload file tidak tersedia di simulasi statis.')">
            <div class="text-3xl mb-2">📄</div>
            <div class="font-semibold text-gray-500 text-sm">Klik untuk upload PDF</div>
            <div class="text-[0.75rem] text-gray-400 mt-1">Mendukung file PDF hingga 10MB</div>
        </div>
        
        <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
            <button class="btn btn-ghost" onclick="document.getElementById('modal-riset').classList.remove('open')">Batal</button>
            <button class="btn btn-primary" onclick="alert('Riset disimpan!'); document.getElementById('modal-riset').classList.remove('open')">📊 Simpan</button>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }
</style>
@endpush