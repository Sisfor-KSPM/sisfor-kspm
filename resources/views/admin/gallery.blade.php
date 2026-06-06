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
        <button class="btn btn-primary btn-sm" onclick="openGalleryModal()">+ Upload Foto</button>
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

                {{-- Step 1: Pilih file --}}
                <label id="gallery-upload-area" for="gallery_foto_dummy" class="border-2 border-dashed border-gray-300 rounded-xl p-5 text-center hover:bg-blue-50 transition cursor-pointer block">
                    <div class="text-3xl mb-1.5">🖼️</div>
                    <div class="font-semibold text-gray-500 text-sm">Klik untuk pilih foto</div>
                    <div class="text-[0.72rem] text-gray-400 mt-1">JPG / PNG / WEBP · maks 5MB · Akan di-crop 4:3</div>
                    <input type="file" id="gallery_foto_dummy" accept="image/jpeg,image/png,image/webp" class="hidden">
                </label>

                {{-- Step 2: Crop area --}}
                <div id="gallery-crop-area" class="hidden mt-3">
                    <p class="text-[0.72rem] text-blue-600 font-semibold mb-2">✂️ Sesuaikan area foto (rasio 4:3 sesuai tampilan gallery)</p>
                    <div class="w-full rounded-xl border border-gray-200 bg-gray-100 mb-3 overflow-hidden" style="height:300px;position:relative;">
                        <img id="gallery-image-to-crop" src="" style="display:block;max-width:100%;">
                    </div>
                    <div class="flex gap-2">
                        <button type="button" id="gallery-btn-cancel" class="btn btn-ghost flex-1 py-2 text-sm">Batal</button>
                        <button type="button" id="gallery-btn-apply" class="btn btn-primary flex-1 py-2 text-sm">✂️ Terapkan</button>
                    </div>
                </div>

                {{-- Step 3: Preview hasil crop --}}
                <div id="gallery-preview-area" class="hidden mt-3 flex items-center justify-between border border-gray-200 rounded-xl p-3 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <img id="gallery-cropped-preview" src="" class="w-20 h-[60px] object-cover rounded-lg border border-gray-200">
                        <div>
                            <div class="text-sm font-semibold text-gray-700">Foto Siap Upload</div>
                            <div class="text-xs text-green-600 font-medium">✓ Sudah di-crop 4:3</div>
                        </div>
                    </div>
                    <button type="button" id="gallery-btn-reset" class="text-xs text-red-500 hover:text-red-700 font-semibold px-3 py-1.5 bg-red-50 rounded-lg hover:bg-red-100 transition">Ganti</button>
                </div>

                {{-- Input hidden: base64 hasil crop, dikirim ke controller --}}
                <input type="hidden" name="foto_base64" id="gallery_foto_base64">
                <p id="gallery-foto-error" class="hidden text-red-500 text-xs mt-1.5 font-medium">⚠ Foto wajib dipilih dan di-crop terlebih dahulu.</p>
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
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal*</label>
                    <input type="date" name="tanggal" class="inp" required>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Fotografer*</label>
                    <input type="text" name="fotografer" class="inp" placeholder="Nama fotografer / media" required>
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
                <button type="button" class="btn btn-primary" onclick="validateAndSubmitGallery()">🖼️ Simpan Foto</button>
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
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<style>
.modal-overlay.open { 
    display: flex !important; 
}
.gallery-card.is-hidden {
    display: none !important;
}
/* Crop box berbentuk rectangle 4:3 — tidak perlu rounded */
#gallery-crop-area .cropper-view-box,
#gallery-crop-area .cropper-face {
    border-radius: 0;
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
// ================================================================
// GALLERY CROP FLOW
// ================================================================
window.galleryCropperInst = null;

function resetGalleryUploadUI() {
    document.getElementById('gallery-upload-area').classList.remove('hidden');
    document.getElementById('gallery-crop-area').classList.add('hidden');
    document.getElementById('gallery-preview-area').classList.add('hidden');
    // Reset value input file dengan replace node (bukan .value='') agar benar-benar kosong
    var old = document.getElementById('gallery_foto_dummy');
    var fresh = old.cloneNode(true);
    old.parentNode.replaceChild(fresh, old);
    // Pasang ulang listener ke input baru
    fresh.addEventListener('change', onGalleryFileSelected);
    document.getElementById('gallery_foto_base64').value = '';
    if (window.galleryCropperInst) {
        window.galleryCropperInst.destroy();
        window.galleryCropperInst = null;
    }
}

// Handler terpisah agar bisa di-re-attach setelah cloneNode
function onGalleryFileSelected(e) {
    var files = e.target.files;
    if (!files || !files.length) return;
    var reader = new FileReader();
    reader.onload = function(ev) {
        var img = document.getElementById('gallery-image-to-crop');
        img.src = ev.target.result;
        document.getElementById('gallery-upload-area').classList.add('hidden');
        document.getElementById('gallery-crop-area').classList.remove('hidden');
        if (window.galleryCropperInst) {
            window.galleryCropperInst.destroy();
            window.galleryCropperInst = null;
        }
        window.galleryCropperInst = new Cropper(img, {
            aspectRatio: 4 / 3,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 1,
            responsive: true,
            restore: false,
            guides: true,
            center: true,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    };
    reader.readAsDataURL(files[0]);
}

// Dipanggil dari onclick tombol "Upload Foto" di header
function openGalleryModal() {
    resetGalleryUploadUI();
    // Reset error foto juga saat buka modal
    var errEl = document.getElementById('gallery-foto-error');
    if (errEl) errEl.classList.add('hidden');
    document.getElementById('modal-gallery').classList.add('open');
}

// Validasi manual sebelum submit — karena foto_base64 adalah hidden input
// yang tidak bisa divalidasi oleh browser native required
function validateAndSubmitGallery() {
    var base64Val = document.getElementById('gallery_foto_base64').value;
    var errEl = document.getElementById('gallery-foto-error');

    if (!base64Val) {
        // Tampilkan error foto
        if (errEl) errEl.classList.remove('hidden');
        // Scroll ke area foto agar user tahu
        document.getElementById('gallery-upload-area').scrollIntoView({ behavior: 'smooth', block: 'center' });
        return;
    }

    if (errEl) errEl.classList.add('hidden');

    // Trigger native validation untuk field lainnya (judul, kategori, tanggal, fotografer, homepage)
    var form = document.querySelector('#modal-gallery form');
    if (!form.checkValidity()) {
        form.reportValidity();
        return;
    }

    form.submit();
}

// Tombol Batal crop
document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('gallery-btn-cancel').addEventListener('click', function(e) {
        e.preventDefault();
        resetGalleryUploadUI();
    });

    // Tombol Terapkan crop
    document.getElementById('gallery-btn-apply').addEventListener('click', function(e) {
        e.preventDefault();
        if (!window.galleryCropperInst) return;
        var canvas = window.galleryCropperInst.getCroppedCanvas({ width: 1200, height: 900 });
        var base64 = canvas.toDataURL('image/jpeg', 0.92);
        document.getElementById('gallery_foto_base64').value = base64;
        document.getElementById('gallery-cropped-preview').src = base64;
        document.getElementById('gallery-crop-area').classList.add('hidden');
        document.getElementById('gallery-preview-area').classList.remove('hidden');
        window.galleryCropperInst.destroy();
        window.galleryCropperInst = null;
    });

    // Tombol Ganti foto
    document.getElementById('gallery-btn-reset').addEventListener('click', function(e) {
        e.preventDefault();
        resetGalleryUploadUI();
    });

    // Pasang listener awal ke input dummy
    var dummy = document.getElementById('gallery_foto_dummy');
    if (dummy) dummy.addEventListener('change', onGalleryFileSelected);

    // ================================================================
    // FILTER GALLERY (search + kategori)
    // ================================================================
    const searchInput = document.querySelector('.search-bar input');
    const categorySelect = document.querySelector('select[name="kategori_filter"]');
    const cards = document.querySelectorAll('.gallery-card');
    const noResults = document.getElementById('no-search-results');

    function filterGallery() {
        const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
        const selectedCategory = categorySelect ? categorySelect.value.toLowerCase() : '';
        let visibleCount = 0;

        cards.forEach(card => {
            const title = card.querySelector('.gallery-title')?.innerText.toLowerCase() || '';
            const meta = card.querySelector('.gallery-meta')?.innerText.toLowerCase() || '';
            const cardCategory = card.getAttribute('data-category') || '';
            const matchesQuery = query === '' || title.includes(query) || meta.includes(query);
            const matchesCategory = selectedCategory === '' || cardCategory === selectedCategory;
            if (matchesQuery && matchesCategory) {
                card.classList.remove('is-hidden');
                visibleCount++;
            } else {
                card.classList.add('is-hidden');
            }
        });

        if (noResults) {
            noResults.classList.toggle('hidden', !(visibleCount === 0 && cards.length > 0));
        }
    }

    if (searchInput) searchInput.addEventListener('input', filterGallery);
    if (categorySelect) categorySelect.addEventListener('change', filterGallery);
});

// ================================================================
// MODAL DELETE
// ================================================================
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