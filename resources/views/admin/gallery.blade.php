{{-- resources/views/admin/gallery.blade.php --}}
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
        
        {{-- KUNCI 1: Value kategori disamakan dengan database & form upload --}}
        <select name="kategori_filter" class="inp inp-sm" style="width:auto">
            <option value="">Semua Kategori</option>
            <option value="investalk">Investalk</option>
            <option value="sekolah">Sekolah PM</option>
            <option value="company">Company Visit</option>
            <option value="kompetisi">Kompetisi</option>
            <option value="internal">Internal</option>
            <option value="lainnya">Lainnya</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-gallery').classList.add('open')">+ Upload Foto</button>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-green-800">
        {{ session('success') }}
    </div>
@endif

<div id="gallery-grid" style="display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px">
    @if($galleries->isEmpty())
        <div id="empty-state" class="col-span-full rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
            Belum ada foto gallery. Tambahkan foto baru lewat tombol Upload Foto.
        </div>
    @else
        @foreach($galleries as $gallery)
            {{-- KUNCI 2: Tambahkan data-attribute agar mempermudah filtering JS --}}
            <div class="card gallery-card overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg" data-category="{{ strtolower($gallery->kategori) }}">
                <div class="h-[180px] overflow-hidden relative bg-slate-100">
                    <img
                        src="{{ asset($gallery->foto_link) }}"
                        alt="{{ $gallery->judul }}"
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 hover:opacity-100 transition duration-300 flex items-end p-4">
                        <div>
                            <span class="bg-white/10 text-white text-[0.65rem] px-2 py-1 rounded-full text-category-badge">{{ ucfirst($gallery->kategori) }}</span>
                            <div class="text-white text-[0.78rem] font-semibold mt-2">{{ $gallery->judul }}</div>
                        </div>
                    </div>
                </div>
                <div class="p-3.5">
                    <div class="font-bold text-[0.88rem] mb-1 truncate text-gray-900 gallery-title">{{ $gallery->judul }}</div>
                    <div class="text-[0.72rem] text-gray-500 mb-2 gallery-meta">📅 {{ $gallery->tanggal ?: '-' }} · 📷 {{ $gallery->fotografer ?: 'N/A' }}</div>
                    <div class="flex gap-2">
                        <button type="button" onclick="openDeleteGallery({{ $gallery->id }}, '{{ addslashes($gallery->judul) }}')" class="btn btn-ghost text-red-500 hover:bg-red-50 border-red-100 btn-sm w-full text-[0.72rem] py-1 px-2.5">Hapus</button>
                    </div>
                </div>
            </div>
        @endforeach
        
        {{-- Tempat penampung jika hasil pencarian tidak ditemukan --}}
        <div id="no-search-results" class="col-span-full rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500 hidden">
            Foto yang Anda cari tidak ditemukan.
        </div>
    @endif
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-gallery">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
                <div class="modal-title text-base font-bold text-gray-900">Upload Foto / Dokumentasi</div>
                <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-gallery').classList.remove('open')">✕</button>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">📸 Upload Foto*</label>
                <input type="file" name="foto" accept="image/*" class="w-full rounded-xl border border-gray-300 p-3" required>
                <p class="text-[0.72rem] text-gray-400 mt-2">JPG / PNG / WEBP · maks 5MB</p>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Judul / Keterangan Foto*</label>
                <input type="text" name="judul" class="inp" placeholder="Workshop Analisis Fundamental 2025" required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori*</label>
                    <select name="kategori" class="inp" required>
                        <option value="">Pilih kategori</option>
                        <option value="investalk">Investalk</option>
                        <option value="sekolah">Sekolah PM</option>
                        <option value="company">Company Visit</option>
                        <option value="kompetisi">Kompetisi</option>
                        <option value="internal">Internal</option>
                        <option value="lainnya">Lainnya</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="inp">
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Fotografer</label>
                    <input type="text" name="fotografer" class="inp" placeholder="Nama fotografer / media">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tampil di Homepage</label>
                    <select name="homepage" class="inp" required>
                        <option value="ya">Ya, tampilkan</option>
                        <option value="tidak">Tidak</option>
                    </select>
                </div>
            </div>
            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-gallery').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">🖼️ Simpan Foto</button>
            </div>
        </form>
    </div>
</div>
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete-gallery">
    <div class="modal bg-white rounded-2xl p-6 w-full max-w-sm relative shadow-xl">
        <div class="text-center">
            {{-- Ikon Peringatan Tengah --}}
            <div class="w-14 h-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                ⚠️
            </div>
            <div class="text-base font-bold text-gray-900 mb-1">Konfirmasi Hapus</div>
            <p class="text-xs text-gray-500 leading-relaxed px-2">
                Apakah Anda yakin ingin menghapus foto <strong id="deleteGalleryTitle" class="text-gray-800 font-semibold">-</strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        
        {{-- Form action yang di-inject via JavaScript --}}
        <form id="deleteGalleryForm" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" class="btn btn-ghost w-1/2 justify-center" onclick="closeDeleteGalleryModal()">
                    Batal
                </button>
                <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white rounded-xl px-4 py-2 text-sm font-semibold transition w-1/2 justify-center shadow-sm">
                    Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
/* KUNCI 3: Pastikan class Tailwind ter-overwrite dengan mutlak menggunakan !important style */
.modal-overlay.open { 
    display: flex !important; 
}
.gallery-card.is-hidden {
    display: none !important;
}
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-bar input');
        const categorySelect = document.querySelector('select[name="kategori_filter"]');
        const cards = document.querySelectorAll('.gallery-card');
        const noResults = document.getElementById('no-search-results');

        function filterGallery() {
            const query = searchInput.value.trim().toLowerCase();
            const selectedCategory = categorySelect ? categorySelect.value.toLowerCase() : '';
            let visibleCount = 0;

            cards.forEach(card => {
                const title = card.querySelector('.gallery-title')?.innerText.toLowerCase() || '';
                const meta = card.querySelector('.gallery-meta')?.innerText.toLowerCase() || '';
                const cardCategory = card.getAttribute('data-category') || '';

                // Cocokkan text query (judul/meta) & kecocokan seleksi kategori
                const matchesQuery = query === '' || title.includes(query) || meta.includes(query);
                const matchesCategory = selectedCategory === '' || cardCategory === selectedCategory;

                if (matchesQuery && matchesCategory) {
                    card.classList.remove('is-hidden');
                    visibleCount++;
                } else {
                    card.classList.add('is-hidden');
                }
            });

            // Tampilkan pesan kosong jika semua card tersembunyi
            if (noResults) {
                if (visibleCount === 0 && cards.length > 0) {
                    noResults.classList.remove('hidden');
                } else {
                    noResults.classList.add('hidden');
                }
            }
        }

        if (searchInput) {
            searchInput.addEventListener('input', filterGallery);
        }

        if (categorySelect) {
            categorySelect.addEventListener('change', filterGallery);
        }
    });

    function openDeleteGallery(id, title) {
        document.getElementById('deleteGalleryTitle').innerText = title;
        const form = document.getElementById('deleteGalleryForm');
        form.action = '{{ url("/admin/gallery") }}/' + id;
        document.getElementById('modal-delete-gallery').classList.add('open');
    }

    function closeDeleteGalleryModal() {
        document.getElementById('modal-delete-gallery').classList.remove('open');
    }
</script>
@endpush