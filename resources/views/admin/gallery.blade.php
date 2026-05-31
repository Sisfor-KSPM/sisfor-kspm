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
        <select name="kategori_filter" class="inp inp-sm" style="width:auto">
            <option value="">Semua Kategori</option>
            <option value="seminar">Seminar</option>
            <option value="workshop">Workshop</option>
            <option value="rapat">Rapat</option>
            <option value="lomba">Lomba</option>
            <option value="sosial">Sosial</option>
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
        <div class="col-span-1 sm:col-span-2 lg:col-span-3 rounded-2xl border border-dashed border-gray-300 p-10 text-center text-gray-500">
            Belum ada foto gallery. Tambahkan foto baru lewat tombol Upload Foto.
        </div>
    @else
        @foreach($galleries as $gallery)
            <div class="card overflow-hidden transition-all hover:-translate-y-1 hover:shadow-lg">
                <div class="h-[180px] overflow-hidden relative bg-slate-100">
                    <img
                        src="{{ asset($gallery->foto_link) }}"
                        alt="{{ $gallery->judul }}"
                        class="w-full h-full object-cover"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent opacity-0 hover:opacity-100 transition duration-300 flex items-end p-4">
                        <div>
                            <span class="bg-white/10 text-white text-[0.65rem] px-2 py-1 rounded-full">{{ ucfirst($gallery->kategori) }}</span>
                            <div class="text-white text-[0.78rem] font-semibold mt-2">{{ $gallery->judul }}</div>
                        </div>
                    </div>
                </div>
                <div class="p-3.5">
                    <div class="font-bold text-[0.88rem] mb-1 truncate text-gray-900">{{ $gallery->judul }}</div>
                    <div class="text-[0.72rem] text-gray-500 mb-2">📅 {{ $gallery->tanggal ?: '-' }} · 📷 {{ $gallery->fotografer ?: 'N/A' }}</div>
                    <div class="flex gap-2">
                        <button type="button" onclick="openDeleteGallery({{ $gallery->id }}, '{{ addslashes($gallery->judul) }}')" class="btn btn-ghost text-red-500 hover:bg-red-50 border-red-100 btn-sm w-full text-[0.72rem] py-1 px-2.5">Hapus</button>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>

<!-- MODAL UPLOAD FOTO/GALLERY -->
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
                @error('foto') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                <p class="text-[0.72rem] text-gray-400 mt-2">JPG / PNG / WEBP · maks 5MB</p>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Judul / Keterangan Foto*</label>
                <input type="text" name="judul" class="inp" placeholder="Workshop Analisis Fundamental 2025" value="{{ old('judul') }}" required>
                @error('judul') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori*</label>
                    <select name="kategori" class="inp" required>
                        <option value="">Pilih kategori</option>
                        <option value="investalk" {{ old('kategori')=='investalk' ? 'selected' : '' }}>Investalk</option>
                        <option value="sekolah" {{ old('kategori')=='sekolah' ? 'selected' : '' }}>Sekolah PM</option>
                        <option value="company" {{ old('kategori')=='company' ? 'selected' : '' }}>Company Visit</option>
                        <option value="kompetisi" {{ old('kategori')=='kompetisi' ? 'selected' : '' }}>Kompetisi</option>
                        <option value="internal" {{ old('kategori')=='internal' ? 'selected' : '' }}>Internal</option>
                        <option value="lainnya" {{ old('kategori')=='lainnya' ? 'selected' : '' }}>Lainnya</option>
                    </select>
                    @error('kategori') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" class="inp" value="{{ old('tanggal') }}">
                    @error('tanggal') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Fotografer</label>
                    <input type="text" name="fotografer" class="inp" placeholder="Nama fotografer / media" value="{{ old('fotografer') }}">
                    @error('fotografer') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tampil di Homepage</label>
                    <select name="homepage" class="inp" required>
                        <option value="ya" {{ old('homepage')=='ya' ? 'selected' : '' }}>Ya, tampilkan</option>
                        <option value="tidak" {{ old('homepage')=='tidak' ? 'selected' : '' }}>Tidak</option>
                    </select>
                    @error('homepage') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>
            
            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-gallery').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">🖼️ Simpan Foto</button>
            </div>
        </form>
    </div>
</div>

<!-- DELETE CONFIRMATION MODAL -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete-gallery">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-md relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900">Hapus Foto Gallery</div>
            <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeDeleteGalleryModal()">✕</button>
        </div>
        <p class="text-gray-600">Apakah Anda yakin ingin menghapus foto berikut?</p>
        <p class="font-semibold text-gray-900 mt-3" id="deleteGalleryTitle">-</p>
        <div class="flex justify-end gap-2 mt-6">
            <button type="button" class="btn btn-ghost" onclick="closeDeleteGalleryModal()">Batal</button>
            <form id="deleteGalleryForm" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
            </form>
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

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.querySelector('.search-bar input');
        const categorySelect = document.querySelector('select[name="kategori_filter"]');
        const cards = document.querySelectorAll('#gallery-grid > .card');

        function filterGallery() {
            const query = searchInput.value.trim().toLowerCase();
            const selected = categorySelect ? categorySelect.value.toLowerCase() : '';

            cards.forEach(card => {
                const title = card.querySelector('.font-bold')?.innerText.toLowerCase() || '';
                const meta = card.querySelector('.text-[0.72rem]')?.innerText.toLowerCase() || '';
                const category = card.querySelector('span')?.innerText.toLowerCase() || '';

                const matchesQuery = query === '' || title.includes(query) || meta.includes(query) || category.includes(query);
                const matchesCategory = selected === '' || selected === 'semua' || category.includes(selected);

                if (matchesQuery && matchesCategory) {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
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
        form.action = '{{ url('/admin/gallery') }}/' + id;
        document.getElementById('modal-delete-gallery').classList.add('open');
    }

    function closeDeleteGalleryModal() {
        document.getElementById('modal-delete-gallery').classList.remove('open');
    }
</script>
@endpush