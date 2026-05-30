@extends('layouts.admin')

@section('page-title', 'Home Content Editor')
@section('page-breadcrumb', 'Kelola Konten Landing Page')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Home Content Editor</div>
        <div class="section-sub text-sm text-gray-500">Kelola konten hero section, ticker, dan statistik di landing page</div>
    </div>
    <button class="btn btn-primary btn-sm" onclick="alert('Perubahan berhasil disimpan!')">💾 Simpan Semua Perubahan</button>
</div>

<div class="grid grid-cols-1 gap-5 mb-5">
    <!-- Hero Section -->
    <div class="card p-6">
        <div class="font-bold text-base mb-4 text-gray-900">🦸 Hero Section</div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Eyebrow / Tagline Kecil</label>
            <input class="inp" value="The Biggest Capital Market Community in SV IPB University" placeholder="Tagline kecil di atas judul">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Judul Utama (H1)</label>
            <input class="inp" value="Kelompok Studi Pasar Modal SV IPB" placeholder="Judul utama hero">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi Hero</label>
            <textarea class="inp" style="min-height:100px">Explore in-depth market analysis, curated watchlist, and comprehensive market research with our dedicated team. Stay informed about the dynamic world of capital markets through our insightful content.</textarea>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tombol Utama (CTA 1)</label><input class="inp" value="Events →" placeholder="Teks tombol"></div>
            <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tombol Sekunder (CTA 2)</label><input class="inp" value="Research →" placeholder="Teks tombol"></div>
        </div>
    </div>
</div>

<!-- Social Media Links -->
<div class="card mb-5 p-6">
    <div class="font-bold mb-4 text-gray-900">🔗 Social Media & Kontak</div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3.5">
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">📸 Instagram URL</label><input class="inp" value="https://instagram.com/kspmsvipb" placeholder="https://instagram.com/..."></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">💼 LinkedIn URL</label><input class="inp" value="https://linkedin.com/company/kspmsvipb" placeholder="https://linkedin.com/..."></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3.5">
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">▶️ YouTube URL</label><input class="inp" value="https://youtube.com/@kspmsvipb" placeholder="https://youtube.com/..."></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">🎵 TikTok URL</label><input class="inp" value="https://tiktok.com/@kspmsvipb" placeholder="https://tiktok.com/..."></div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">📧 Email Kontak</label><input class="inp" value="info@kspmsvipb.ac.id" placeholder="email@..."></div>
        <div><label class="block text-xs font-semibold text-gray-500 mb-1">📱 WhatsApp/HP</label><input class="inp" value="081234567890" placeholder="08xxxxxxxxxx"></div>
    </div>
</div>
@endsection

@push('styles')
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }
</style>
@endpush