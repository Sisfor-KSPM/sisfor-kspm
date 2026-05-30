@extends('layouts.admin')

@section('page-title', 'About / Tentang KSPM')
@section('page-breadcrumb', 'Kelola Konten Halaman About')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">About / Tentang KSPM</div>
        <div class="section-sub text-sm text-gray-500">Kelola konten halaman About di landing page</div>
    </div>
    <button class="btn btn-primary btn-sm" onclick="alert('Perubahan berhasil disimpan!')">💾 Simpan Perubahan</button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
    <!-- Profil Organisasi -->
    <div class="card p-6">
        <div class="font-bold text-base mb-4 flex items-center gap-2 text-gray-900">🏛️ Profil Organisasi</div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Organisasi</label>
            <input type="text" class="inp" value="KSPM SV IPB" placeholder="Nama organisasi">
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Singkatan</label>
            <input type="text" class="inp" value="KSPM SV IPB" placeholder="KSPM">
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Kepanjangan</label>
            <input type="text" class="inp" value="Kelompok Studi Pasar Modal SV IPB" placeholder="Kelompok Studi...">
        </div>

        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Singkat (Hero Section)</label>
            <textarea class="inp" rows="3" placeholder="Deskripsi untuk hero...">KSPM SV IPB adalah komunitas mahasiswa yang berfokus pada edukasi dan praktik pasar modal, berafiliasi dengan Bursa Efek Indonesia melalui Investment Gallery.</textarea>
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Visi</label>
            <textarea class="inp" rows="3" placeholder="Visi organisasi...">Menjadi wadah pengembangan pengetahuan dan kompetensi pasar modal mahasiswa SV IPB yang unggul, profesional, dan berdampak nyata.</textarea>
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Misi</label>
            <textarea class="inp" rows="4" placeholder="Misi organisasi...">Mengedukasi anggota tentang pasar modal Indonesia, memfasilitasi praktik investasi nyata, membangun jaringan profesional, dan berkontribusi pada literasi keuangan kampus.</textarea>
        </div>
        
        
    </div>

    <!-- Logo & Foto -->
    <div class="card p-6">
        <div class="font-bold text-base mb-4 text-gray-900">🖼️ Logo & Foto Organisasi</div>
        
        <div class="mb-5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Logo Utama</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer" onclick="alert('Fitur upload gambar statis')">
                <div class="text-4xl mb-2">🏦</div>
                <div class="font-semibold text-gray-500 text-sm">Klik atau drag & drop logo</div>
                <div class="text-xs text-gray-400 mt-1">PNG/JPG/SVG · maks 2MB</div>
            </div>
        </div>
        
        <div>
            <label class="block text-xs font-semibold text-gray-500 mb-1">Foto Kegiatan / Hero Background</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer" onclick="alert('Fitur upload gambar statis')">
                <div class="text-4xl mb-2">🖼️</div>
                <div class="font-semibold text-gray-500 text-sm">Foto untuk hero section landing page</div>
                <div class="text-xs text-gray-400 mt-1">Rekomendasi: 1200×600px · JPG/PNG</div>
            </div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="card p-6 mb-5">
    <div class="font-bold mb-4 text-gray-900">📊 Statistik (ditampilkan di homepage)</div>
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tahun Berdiri</label><input class="inp" value="2018"></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Total Anggota</label><input class="inp" value="247+"></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tahun Aktif</label><input class="inp" value="6+"></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Program Kerja</label><input class="inp" value="18+"></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">Publikasi Riset</label><input class="inp" value="24+"></div>
    </div>
</div>

<!-- Pengurus -->
<div class="card p-6">
    <div class="flex items-center justify-between mb-4 flex-wrap">
        <div>
            <div class="font-bold text-gray-900">👑 Data Pengurus / BPH</div>
            <div class="text-xs text-gray-500 mt-1">Tampil di halaman About landing page</div>
        </div>
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-pengurus').classList.add('open')">+ Tambah Pengurus</button>
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
                <!-- Pengurus 1 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-xs">RF</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-gray-900">Rizky Firmansyah</div>
                        <div class="text-[0.72rem] text-gray-500 font-mono">J0401211067</div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Ketua Umum</span></td>
                    <td class="px-4 py-3 text-[0.82rem]">BPH (Badan Pengurus Harian)</td>
                    <td class="px-4 py-3 text-[0.82rem]">2024/2025</td>
                    <td class="px-4 py-3 text-[0.78rem] text-gray-500">@rizky.firmansyah</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
                <!-- Pengurus 2 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-xs">SD</div>
                    </td>
                    <td class="px-4 py-3">
                        <div class="font-semibold text-gray-900">Sari Dewi Putri</div>
                        <div class="text-[0.72rem] text-gray-500 font-mono">J0401221034</div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">Sekretaris Umum</span></td>
                    <td class="px-4 py-3 text-[0.82rem]">BPH (Badan Pengurus Harian)</td>
                    <td class="px-4 py-3 text-[0.82rem]">2024/2025</td>
                    <td class="px-4 py-3 text-[0.78rem] text-gray-500">sari@apps.ipb.ac.id</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL TAMBAH PENGURUS -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-pengurus">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900">Tambah Pengurus</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-pengurus').classList.remove('open')">✕</button>
        </div>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Nama Lengkap*</label><input class="inp" placeholder="Nama lengkap pengurus"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">NIM</label><input class="inp" placeholder="J0X00000000"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Jabatan*</label>
                <select class="inp">
                    <option>Ketua Umum</option><option>Wakil Ketua</option><option>Sekretaris Umum</option><option>Bendahara Umum</option>
                    <option>Koordinator Divisi</option><option>Staff</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">Divisi</label>
                <select class="inp">
                    <option>BPH (Badan Pengurus Harian)</option>
                    <option>Administration</option><option>Education</option><option>Media Creative</option>
                    <option>Public Relation</option><option>Investment Gallery</option><option>Analyze Trading</option>
                </select>
            </div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Periode Kepengurusan</label><input class="inp" placeholder="2024/2025"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Angkatan</label><input class="inp" placeholder="2022"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Email / Instagram</label><input class="inp" placeholder="@username / email"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">LinkedIn</label><input class="inp" placeholder="linkedin.com/in/..."></div>
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Foto Pengurus</label>
            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:bg-blue-50 transition cursor-pointer" onclick="alert('Upload gambar statis')">
                <div class="text-4xl mb-2">👤</div>
                <div class="font-semibold text-gray-500 text-sm">Upload foto pengurus</div>
                <div class="text-[0.72rem] text-gray-400 mt-1">JPG/PNG · 300×300px · maks 1MB</div>
            </div>
        </div>
        
        <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
            <button class="btn btn-ghost" onclick="document.getElementById('modal-pengurus').classList.remove('open')">Batal</button>
            <button class="btn btn-primary" onclick="alert('Pengurus disimpan!'); document.getElementById('modal-pengurus').classList.remove('open')">💾 Simpan</button>
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