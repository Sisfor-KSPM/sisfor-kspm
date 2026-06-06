@extends('layouts.admin')

@section('page-title', 'About / Tentang KSPM')
@section('page-breadcrumb', 'Kelola Konten Halaman About')

@section('content')

<form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
        <div>
            <div class="section-title text-lg font-bold text-gray-900">About / Tentang KSPM</div>
            <div class="section-sub text-sm text-gray-500">Kelola konten halaman About di landing page</div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">💾 Simpan Perubahan</button>
    </div>

    @if(session('success'))
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50">{{ session('success') }}</div>
    @endif

    <div class="grid grid-cols-1 gap-5 mb-5">
        <div class="card p-6">
            <div class="mb-5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Logo Utama</label>

                {{-- Upload area logo --}}
                <label id="logo-upload-area" for="logo_input_dummy" class="border-2 border-dashed border-gray-300 rounded-xl p-4 text-center hover:bg-blue-50 transition cursor-pointer block">
                    @if($about && $about->logo)
                        <img src="{{ asset('storage/' . $about->logo) }}" alt="Logo KSPM" id="logo-current-img" class="h-16 w-auto object-contain mx-auto mb-2">
                        <div class="font-semibold text-gray-500 text-xs">Klik untuk ganti logo</div>
                    @else
                        <div class="text-2xl mb-1">🏦</div>
                        <div class="font-semibold text-gray-500 text-xs">Klik untuk upload logo</div>
                    @endif
                    <div class="text-[10px] text-gray-400">PNG/JPG/SVG · maks 2MB · Akan di-crop bulat</div>
                    <input type="file" id="logo_input_dummy" accept=".jpg,.jpeg,.png,.svg" class="hidden">
                </label>

                {{-- Area crop logo --}}
                <div id="logo-crop-area" class="hidden mt-3">
                    <div class="w-full h-[250px] sm:h-[320px] rounded-xl border border-gray-200 bg-gray-100 mb-3 overflow-hidden relative">
                        <img id="logo-image-to-crop" src="" style="display:block;max-width:100%;">
                    </div>
                    <div class="flex gap-2">
                        <button type="button" id="logo-btn-cancel" class="btn btn-ghost flex-1 py-2 text-sm">Batal</button>
                        <button type="button" id="logo-btn-apply" class="btn btn-primary flex-1 py-2 text-sm">✂️ Terapkan Potongan</button>
                    </div>
                </div>

                {{-- Preview setelah crop logo --}}
                <div id="logo-preview-area" class="hidden mt-3 flex items-center justify-between border border-gray-200 rounded-xl p-4 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <img id="logo-cropped-preview" src="" class="w-14 h-14 rounded-full object-cover shadow-sm border border-gray-200 bg-transparent">
                        <div>
                            <div class="text-sm font-semibold text-gray-700">Logo Siap Upload</div>
                            <div class="text-xs text-green-600 font-medium">✓ Sudah dipotong membulat</div>
                        </div>
                    </div>
                    <button type="button" id="logo-btn-reset" class="text-xs text-red-500 hover:text-red-700 font-semibold px-3 py-1.5 bg-red-50 rounded-lg hover:bg-red-100 transition">Ganti Logo</button>
                </div>

                {{-- Hidden input base64 yang dikirim ke server --}}
                <input type="hidden" name="logo_base64" id="logo_base64_input">
                @error('logo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>

            <div class="font-bold text-base mb-4 flex items-center gap-2 text-gray-900">🏛️ Profil Organisasi</div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Organisasi</label>
                <input type="text" name="nama" class="inp" value="{{ old('nama', $about->nama ?? '') }}" placeholder="Nama organisasi">
                @error('nama') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Singkatan</label>
                <input type="text" name="singkatan" class="inp" value="{{ old('singkatan', $about->singkatan ?? '') }}" placeholder="KSPM">
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Kepanjangan</label>
                <input type="text" name="kepanjangan" class="inp" value="{{ old('kepanjangan', $about->kepanjangan ?? '') }}" placeholder="Kelompok Studi...">
            </div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Singkat (Hero Section)</label>
                <textarea name="deskripsi" class="inp" rows="3" placeholder="Deskripsi untuk hero...">{{ old('deskripsi', $about->deskripsi ?? '') }}</textarea>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Visi</label>
                <textarea name="visi" class="inp" rows="3" placeholder="Visi organisasi...">{{ old('visi', $about->visi ?? '') }}</textarea>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Misi</label>
                <textarea name="misi" class="inp" rows="4" placeholder="Misi organisasi...">{{ old('misi', $about->misi ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <div class="card p-6 mb-5">
        <div class="font-bold mb-4 text-gray-900">📊 Statistik (ditampilkan di homepage)</div>
        <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tahun Berdiri</label><input type="text" name="tahun_berdiri" class="inp" value="{{ old('tahun_berdiri', $about->tahun_berdiri ?? '') }}"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Total Anggota</label><input type="text" name="total_anggota" class="inp" value="{{ old('total_anggota', $about->total_anggota ?? '') }}"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tahun Aktif</label><input type="text" name="tahun_aktif" class="inp" value="{{ old('tahun_aktif', $about->tahun_aktif ?? '') }}"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Program Kerja</label><input type="text" name="program_kerja" class="inp" value="{{ old('program_kerja', $about->program_kerja ?? '') }}"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Publikasi Riset</label><input type="text" name="publikasi_riset" class="inp" value="{{ old('publikasi_riset', $about->publikasi_riset ?? '') }}"></div>
        </div>
    </div>
</form>

<div class="card p-6">
    <div class="flex items-center justify-between mb-4 flex-wrap">
        <div>
            <div class="font-bold text-gray-900">👑 Data Pengurus / BPH</div>
            <div class="text-xs text-gray-500 mt-1">Tampil di halaman About landing page</div>
        </div>
        <button type="button" class="btn btn-primary btn-sm" onclick="openTambahPengurus()">➕ Tambah Pengurus</button>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Foto</th>
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Jabatan</th>
                    <th class="px-4 py-3">Divisi</th>
                    <th class="px-4 py-3">Periode</th>
                    <th class="px-4 py-3">Kontak</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pengurus as $item)
                    <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                        <td class="px-4 py-3">
                            @if($item->foto_pengurus)
                                <img src="{{ asset('storage/'.$item->foto_pengurus) }}" class="w-10 h-10 rounded-full object-cover" alt="{{ $item->nama }}">
                            @else
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-xs">
                                    {{ strtoupper(substr($item->nama,0,1)) }}
                                </div>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900">{{ $item->nama }}</div>
                            <div class="text-[0.72rem] text-gray-500 font-mono">{{ $item->nim }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">{{ $item->jabatan }}</span>
                        </td>
                        <td class="px-4 py-3 text-[0.82rem]">{{ $item->divisi }}</td>
                        <td class="px-4 py-3 text-[0.82rem]">{{ $item->periode }}</td>
                        <td class="px-4 py-3 text-[0.78rem] text-gray-500">{{ $item->email }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button type="button" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-blue-50 text-blue-600 hover:bg-blue-100 transition" onclick='editPengurus(@json($item))'>✏️</button>
                            <button type="button" class="inline-flex items-center justify-center w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 transition ml-1" onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->nama) }}', '{{ route('pengurus.destroy', $item->id) }}')">🗑️</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center py-8 text-gray-400">Belum ada data pengurus</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-pengurus">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
        <form id="pengurusForm" action="{{ route('pengurus.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" id="methodField">

            <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
                <div id="modalTitle" class="modal-title text-base font-bold text-gray-900">Tambah Pengurus</div>
                <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-pengurus').classList.remove('open')">✕</button>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap (Wajib Diisi)</label>
                    <input type="text" id="nama" name="nama" class="inp" required>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">NIM (Wajib Diisi)</label>
                    <input type="text" id="nim" name="nim" class="inp">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Jabatan (Wajib Diisi)</label>
                    <select id="jabatan" name="jabatan" class="inp" required>
                        <option value="">Pilih Jabatan</option>
                        <option value="Ketua Umum">Ketua Umum</option>
                        <option value="Wakil Ketua">Wakil Ketua</option>
                        <option value="Sekretaris Umum">Sekretaris Umum</option>
                        <option value="Bendahara Umum">Bendahara Umum</option>
                        <option value="Koordinator Divisi">Koordinator Divisi</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Divisi (Wajib Diisi)</label>
                    <select id="divisi" name="divisi" class="inp" required>
                        <option value="">Pilih Divisi</option>
                        <option value="BPH (Badan Pengurus Harian)">BPH (Badan Pengurus Harian)</option>
                        <option value="Administration">Administration</option>
                        <option value="Education">Education</option>
                        <option value="Media Creative">Media Creative</option>
                        <option value="Public Relation">Public Relation</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Periode Kepengurusan (Wajib Diisi)</label>
                    <input type="text" name="periode" id="periode" class="inp" placeholder="2025/2026">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Angkatan (Wajib Diisi)</label>
                    <input type="text" name="angkatan" id="angkatan" class="inp" placeholder="2023">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Email / Instagram (Wajib Diisi)</label>
                    <input type="text" name="email" id="email" class="inp">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">LinkedIn (Wajib Diisi)</label>
                    <input type="text" name="linkedin" id="linkedin" class="inp">
                </div>
            </div>

            <div class="mb-5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Foto Pengurus (Wajib Diisi)</label>
                <label id="upload-area" class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer block">
                    <div class="text-4xl mb-2">👤</div>
                    <div class="font-semibold text-gray-500 text-sm">Pilih Foto Pengurus</div>
                    <div class="text-[0.72rem] text-gray-400 mt-1">Akan dipotong presisi membulat</div>
                    <input type="file" id="foto_input_dummy" accept=".jpg,.jpeg,.png" class="hidden">
                </label>

                <div id="crop-area" class="hidden mt-3">
                    <div class="w-full h-[250px] sm:h-[350px] rounded-xl border border-gray-200 bg-gray-100 mb-3 overflow-hidden relative">
                        <img id="image-to-crop" src="" style="display: block; max-width: 100%;">
                    </div>
                    <div class="flex gap-2">
                        <button type="button" id="btn-cancel-crop" class="btn btn-ghost flex-1 py-2 text-sm">Batal</button>
                        <button type="button" id="btn-apply-crop" class="btn btn-primary flex-1 py-2 text-sm">✂️ Terapkan Potongan</button>
                    </div>
                </div>

                <div id="preview-area" class="hidden mt-3 flex items-center justify-between border border-gray-200 rounded-xl p-4 bg-gray-50">
                    <div class="flex items-center gap-3">
                        <img id="cropped-preview" src="" class="w-14 h-14 rounded-full object-cover shadow-sm border border-gray-200 bg-transparent">
                        <div>
                            <div class="text-sm font-semibold text-gray-700">Foto Siap Upload</div>
                            <div class="text-xs text-green-600 font-medium">✓ Sudah dipotong membulat</div>
                        </div>
                    </div>
                    <button type="button" id="btn-reset-foto" class="text-xs text-red-500 hover:text-red-700 font-semibold px-3 py-1.5 bg-red-50 rounded-lg hover:bg-red-100 transition">Ganti Foto</button>
                </div>

                <input type="file" id="foto_pengurus_real" name="foto_pengurus" class="hidden" accept=".png">
            </div>

            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2">
                <button type="button" class="btn btn-ghost" onclick="document.getElementById('modal-pengurus').classList.remove('open')">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan Pengurus</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-md relative">
        <div class="modal-header flex items-center justify-between mb-5">
            <div class="text-base font-bold text-gray-900">Konfirmasi Hapus</div>
            <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeDeleteModal()">✕</button>
        </div>
        <div class="mb-6">
            <p class="text-gray-600 text-sm">Apakah Anda yakin ingin menghapus pengurus berikut?</p>
            <p class="text-gray-900 font-semibold mt-2" id="deleteName">-</p>
        </div>
        <div class="mt-6 pt-4 border-t border-gray-200 flex justify-end gap-2">
            <button type="button" class="btn btn-ghost" onclick="closeDeleteModal()">Batal</button>
            <form id="deleteForm" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">🗑️ Hapus</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" rel="stylesheet">
<style>
.modal-overlay.open { display: flex !important; }
.btn-ghost { background: #f3f4f6; color: #6b7280; }
.btn-ghost:hover { background: #e5e7eb; }
.btn-danger { background: #dc2626; color: #fff; }
.btn-danger:hover { background: #b91c1c; }

/* Membuat antarmuka pemotong berbentuk bulat visual */
.cropper-view-box,
.cropper-face {
  border-radius: 50%;
}
.cropper-dashed,
.cropper-line {
  display: none !important;
}
.cropper-view-box {
  outline: 2px solid #fff;
  outline-color: rgba(255, 255, 255, 0.75);
}
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
// ============================================================
// HELPER GLOBAL
// ============================================================
window.cropperInst     = null; // untuk foto pengurus (modal)
window.logoCropperInst = null; // untuk logo utama (halaman)

// Buat canvas hasil crop berbentuk lingkaran transparan (PNG)
function getRoundedCanvas(sourceCanvas) {
    var c = document.createElement('canvas');
    var ctx = c.getContext('2d');
    c.width = sourceCanvas.width;
    c.height = sourceCanvas.height;
    ctx.imageSmoothingEnabled = true;
    ctx.drawImage(sourceCanvas, 0, 0);
    ctx.globalCompositeOperation = 'destination-in';
    ctx.beginPath();
    ctx.arc(c.width / 2, c.height / 2, Math.min(c.width, c.height) / 2, 0, 2 * Math.PI, true);
    ctx.fill();
    return c;
}

// ============================================================
// LOGO UTAMA — crop flow di halaman (bukan modal)
// ============================================================
function resetLogoUI() {
    document.getElementById('logo-upload-area').classList.remove('hidden');
    document.getElementById('logo-crop-area').classList.add('hidden');
    document.getElementById('logo-preview-area').classList.add('hidden');
    document.getElementById('logo_input_dummy').value = '';
    document.getElementById('logo_base64_input').value = '';
    if (window.logoCropperInst) {
        window.logoCropperInst.destroy();
        window.logoCropperInst = null;
    }
}

document.getElementById('logo_input_dummy').addEventListener('change', function(e) {
    var files = e.target.files;
    if (!files || !files.length) return;
    var reader = new FileReader();
    reader.onload = function(ev) {
        var img = document.getElementById('logo-image-to-crop');
        img.src = ev.target.result;
        document.getElementById('logo-upload-area').classList.add('hidden');
        document.getElementById('logo-crop-area').classList.remove('hidden');
        if (window.logoCropperInst) { window.logoCropperInst.destroy(); }
        window.logoCropperInst = new Cropper(img, {
            aspectRatio: 1,
            viewMode: 1,
            dragMode: 'move',
            autoCropArea: 0.9,
            responsive: true,
            restore: false,
            guides: false,
            center: false,
            highlight: false,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    };
    reader.readAsDataURL(files[0]);
});

document.getElementById('logo-btn-cancel').addEventListener('click', function(e) {
    e.preventDefault();
    resetLogoUI();
});

document.getElementById('logo-btn-apply').addEventListener('click', function(e) {
    e.preventDefault();
    if (!window.logoCropperInst) return;
    var canvas  = window.logoCropperInst.getCroppedCanvas({ width: 500, height: 500 });
    var rounded = getRoundedCanvas(canvas);
    // Simpan sebagai base64 di hidden input (dikirim ke controller)
    var base64 = rounded.toDataURL('image/png', 1.0);
    document.getElementById('logo_base64_input').value = base64;
    document.getElementById('logo-cropped-preview').src = base64;
    document.getElementById('logo-crop-area').classList.add('hidden');
    document.getElementById('logo-preview-area').classList.remove('hidden');
    window.logoCropperInst.destroy();
    window.logoCropperInst = null;
});

document.getElementById('logo-btn-reset').addEventListener('click', function(e) {
    e.preventDefault();
    resetLogoUI();
});

// ============================================================
// FOTO PENGURUS (MODAL) — crop flow
// ============================================================
function resetFotoUI() {
    document.getElementById('upload-area').classList.remove('hidden');
    document.getElementById('crop-area').classList.add('hidden');
    document.getElementById('preview-area').classList.add('hidden');
    // Reset input dengan replace node agar value benar-benar kosong
    var dummy = document.getElementById('foto_input_dummy');
    dummy.value = '';
    document.getElementById('foto_pengurus_real').value = '';
    if (window.cropperInst) {
        window.cropperInst.destroy();
        window.cropperInst = null;
    }
}

// Pasang ulang event listener tiap modal dibuka (cegah duplikasi pakai flag)
function initCropperListeners() {
    // Gunakan teknik replace node untuk benar-benar hapus listener lama
    function replaceNode(id) {
        var el = document.getElementById(id);
        var clone = el.cloneNode(true);
        el.parentNode.replaceChild(clone, el);
        return clone;
    }

    // Foto input: JANGAN replace label wrapper, cukup input-nya saja
    var dummy = replaceNode('foto_input_dummy');
    replaceNode('btn-cancel-crop');
    replaceNode('btn-apply-crop');
    replaceNode('btn-reset-foto');

    // Pastikan label upload-area tetap trigger input baru
    var uploadLabel = document.getElementById('upload-area');
    uploadLabel.setAttribute('for', 'foto_input_dummy');
    uploadLabel.onclick = function() {
        document.getElementById('foto_input_dummy').click();
    };

    // Pilih file → tampilkan cropper
    document.getElementById('foto_input_dummy').addEventListener('change', function(e) {
        var files = e.target.files;
        if (!files || !files.length) return;
        var reader = new FileReader();
        reader.onload = function(ev) {
            var img = document.getElementById('image-to-crop');
            img.src = ev.target.result;
            document.getElementById('upload-area').classList.add('hidden');
            document.getElementById('crop-area').classList.remove('hidden');
            if (window.cropperInst) { window.cropperInst.destroy(); }
            window.cropperInst = new Cropper(img, {
                aspectRatio: 1,
                viewMode: 1,
                dragMode: 'move',
                autoCropArea: 0.9,
                responsive: true,
                restore: false,
                guides: false,
                center: false,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        };
        reader.readAsDataURL(files[0]);
    });

    // Batal crop
    document.getElementById('btn-cancel-crop').addEventListener('click', function(e) {
        e.preventDefault();
        resetFotoUI();
    });

    // Terapkan crop → masukkan ke hidden file input
    document.getElementById('btn-apply-crop').addEventListener('click', function(e) {
        e.preventDefault();
        if (!window.cropperInst) return;
        var canvas  = window.cropperInst.getCroppedCanvas({ width: 500, height: 500 });
        var rounded = getRoundedCanvas(canvas);
        rounded.toBlob(function(blob) {
            var fileName = 'foto_pengurus_' + Date.now() + '.png';
            var file = new File([blob], fileName, { type: 'image/png', lastModified: Date.now() });
            var dt = new DataTransfer();
            dt.items.add(file);
            document.getElementById('foto_pengurus_real').files = dt.files;
            document.getElementById('cropped-preview').src = URL.createObjectURL(blob);
            document.getElementById('crop-area').classList.add('hidden');
            document.getElementById('preview-area').classList.remove('hidden');
            window.cropperInst.destroy();
            window.cropperInst = null;
        }, 'image/png', 1.0);
    });

    // Ganti foto
    document.getElementById('btn-reset-foto').addEventListener('click', function(e) {
        e.preventDefault();
        resetFotoUI();
    });
}

// ============================================================
// MODAL PENGURUS
// ============================================================
function openTambahPengurus() {
    var form = document.getElementById('pengurusForm');
    form.reset();
    form.action = "{{ route('pengurus.store') }}";
    document.getElementById('modalTitle').innerText = 'Tambah Pengurus';
    var mf = document.getElementById('methodField');
    if (mf) { mf.removeAttribute('name'); mf.value = ''; }
    resetFotoUI();
    initCropperListeners();
    document.getElementById('modal-pengurus').classList.add('open');
}

function editPengurus(data) {
    var form = document.getElementById('pengurusForm');
    document.getElementById('modalTitle').innerText = 'Edit Pengurus';
    document.getElementById('nama').value      = data.nama      ?? '';
    document.getElementById('nim').value       = data.nim       ?? '';
    document.getElementById('jabatan').value   = data.jabatan   ?? '';
    document.getElementById('divisi').value    = data.divisi    ?? '';
    document.getElementById('periode').value   = data.periode   ?? '';
    document.getElementById('angkatan').value  = data.angkatan  ?? '';
    document.getElementById('email').value     = data.email     ?? '';
    document.getElementById('linkedin').value  = data.linkedin  ?? '';
    form.action = "{{ url('/admin/pengurus') }}/" + data.id;
    var mf = document.getElementById('methodField');
    if (mf) { mf.setAttribute('name', '_method'); mf.value = 'PUT'; }
    resetFotoUI();
    initCropperListeners();
    document.getElementById('modal-pengurus').classList.add('open');
}

// ============================================================
// MODAL DELETE
// ============================================================
function openDeleteModal(id, nama, deleteRoute) {
    document.getElementById('deleteName').innerText = nama;
    document.getElementById('deleteForm').action = deleteRoute;
    document.getElementById('modal-delete').classList.add('open');
}
function closeDeleteModal() {
    document.getElementById('modal-delete').classList.remove('open');
}
</script>
@endpush