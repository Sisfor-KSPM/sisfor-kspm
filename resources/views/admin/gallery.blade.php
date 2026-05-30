@extends('layouts.admin')

@section('page-title', 'Gallery')
@section('page-breadcrumb', 'Kelola Foto & Dokumentasi')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Gallery</div>
        <div class="section-sub text-sm text-gray-500">Kelola foto & dokumentasi kegiatan KSPM</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <div class="search-bar relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input class="inp inp-sm pl-9" placeholder="Cari foto...">
        </div>
        <select class="inp inp-sm" style="width:auto">
            <option value="">Semua Kategori</option>
            <option>Seminar</option>
            <option>Workshop</option>
            <option>Rapat</option>
            <option>Lomba</option>
            <option>Sosial</option>
            <option>Lainnya</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-gallery').classList.add('open')">+ Upload Foto</button>
    </div>
</div>

<div id="gallery-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px">
    
    <!-- Gallery Item 1 -->
    <div class="card overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg">
        <div class="h-[180px] bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center relative">
            <div class="text-5xl opacity-50">🖼️</div>
            <div class="absolute top-2 left-2 flex gap-1">
                <span class="bg-purple-100 text-purple-800 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">Seminar</span>
                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">● Publik</span>
            </div>
            <div class="absolute top-2 right-2 flex gap-1">
                <button class="bg-white/90 text-blue-600 text-[0.7rem] px-2 py-1 rounded-lg font-bold">✏️ Edit</button>
            </div>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-white/20 border border-white/30 text-white text-[0.65rem] px-2 py-1 rounded-md backdrop-blur-sm cursor-pointer">📸 Upload Foto</div>
        </div>
        <div class="p-3.5">
            <div class="font-bold text-[0.88rem] mb-1 truncate text-gray-900">Sekolah Pasar Modal Batch 1</div>
            <div class="text-[0.72rem] text-gray-500 mb-2">📅 2025-02-10 · 📷 Media Creative</div>
            <div class="flex gap-2">
                <button class="btn btn-outline border-blue-600 text-blue-700 bg-white btn-sm flex-1 text-[0.72rem] justify-center py-1">🖼️ Ganti Foto</button>
                <button class="btn btn-ghost text-red-500 hover:bg-red-50 border-red-100 btn-sm text-[0.72rem] py-1 px-2.5">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Gallery Item 2 -->
    <div class="card overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg">
        <div class="h-[180px] bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center relative">
            <div class="text-5xl opacity-50">🖼️</div>
            <div class="absolute top-2 left-2 flex gap-1">
                <span class="bg-cyan-100 text-cyan-800 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">Workshop</span>
                <span class="bg-green-100 text-green-800 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">● Publik</span>
            </div>
            <div class="absolute top-2 right-2 flex gap-1">
                <button class="bg-white/90 text-blue-600 text-[0.7rem] px-2 py-1 rounded-lg font-bold">✏️ Edit</button>
            </div>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-white/20 border border-white/30 text-white text-[0.65rem] px-2 py-1 rounded-md backdrop-blur-sm cursor-pointer">📸 Upload Foto</div>
        </div>
        <div class="p-3.5">
            <div class="font-bold text-[0.88rem] mb-1 truncate text-gray-900">Workshop Analisis Teknikal</div>
            <div class="text-[0.72rem] text-gray-500 mb-2">📅 2025-01-25 · 📷 Media Creative</div>
            <div class="flex gap-2">
                <button class="btn btn-outline border-blue-600 text-blue-700 bg-white btn-sm flex-1 text-[0.72rem] justify-center py-1">🖼️ Ganti Foto</button>
                <button class="btn btn-ghost text-red-500 hover:bg-red-50 border-red-100 btn-sm text-[0.72rem] py-1 px-2.5">Hapus</button>
            </div>
        </div>
    </div>

    <!-- Gallery Item 3 -->
    <div class="card overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg">
        <div class="h-[180px] bg-gradient-to-br from-blue-900 to-blue-700 flex items-center justify-center relative">
            <div class="text-5xl opacity-50">🖼️</div>
            <div class="absolute top-2 left-2 flex gap-1">
                <span class="bg-gray-100 text-gray-800 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">Rapat</span>
                <span class="bg-slate-100 text-slate-600 px-2 py-0.5 rounded-full text-[0.6rem] font-semibold">Draft</span>
            </div>
            <div class="absolute top-2 right-2 flex gap-1">
                <button class="bg-white/90 text-blue-600 text-[0.7rem] px-2 py-1 rounded-lg font-bold">✏️ Edit</button>
            </div>
            <div class="absolute bottom-2 left-1/2 -translate-x-1/2 bg-white/20 border border-white/30 text-white text-[0.65rem] px-2 py-1 rounded-md backdrop-blur-sm cursor-pointer">📸 Upload Foto</div>
        </div>
        <div class="p-3.5">
            <div class="font-bold text-[0.88rem] mb-1 truncate text-gray-900">Rapat Evaluasi Semester</div>
            <div class="text-[0.72rem] text-gray-500 mb-2">📅 2025-01-15 · 📷 Admin</div>
            <div class="flex gap-2">
                <button class="btn btn-outline border-blue-600 text-blue-700 bg-white btn-sm flex-1 text-[0.72rem] justify-center py-1">🖼️ Ganti Foto</button>
                <button class="btn btn-ghost text-red-500 hover:bg-red-50 border-red-100 btn-sm text-[0.72rem] py-1 px-2.5">Hapus</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL UPLOAD FOTO/GALLERY -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-gallery">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900">Upload Foto / Dokumentasi</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-gallery').classList.remove('open')">✕</button>
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">📸 Upload / Ganti Foto*</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer relative" onclick="alert('Upload gambar statis')">
                <div class="text-4xl mb-2">🖼️</div>
                <div class="font-semibold text-gray-500 text-sm">Klik area ini atau drag & drop foto</div>
                <div class="text-[0.72rem] text-gray-400 mt-1">JPG / PNG / WEBP · maks 5MB</div>
                <div class="absolute bottom-2 right-2">
                    <span class="bg-blue-100 text-blue-800 px-2 py-0.5 rounded-full text-[0.65rem] font-semibold cursor-pointer">📁 Pilih File</span>
                </div>
            </div>
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul / Keterangan Foto*</label>
            <input class="inp" placeholder="Workshop Analisis Fundamental 2025">
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori*</label>
                <select class="inp">
                    <option>Seminar</option><option>Workshop</option><option>Rapat</option>
                    <option>Lomba</option><option>Sosial</option><option>Lainnya</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal Kegiatan</label>
                <input type="date" class="inp">
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Fotografer</label>
                <input class="inp" placeholder="Nama fotografer / Media Creative">
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Tampil di Homepage</label>
                <select class="inp">
                    <option value="1">Ya, tampilkan</option><option value="0">Tidak (draft)</option>
                </select>
            </div>
        </div>
        
        <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
            <button class="btn btn-ghost" onclick="document.getElementById('modal-gallery').classList.remove('open')">Batal</button>
            <button class="btn btn-primary" onclick="alert('Foto disimpan!'); document.getElementById('modal-gallery').classList.remove('open')">🖼️ Simpan Foto</button>
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