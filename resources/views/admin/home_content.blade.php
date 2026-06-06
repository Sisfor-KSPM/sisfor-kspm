@extends('layouts.admin')

@section('page-title', 'Home Content Editor')
@section('page-breadcrumb', 'Kelola Konten Landing Page')

@section('content')

<form action="{{ route('admin.home-content.update') }}" method="POST">
    @csrf

    <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
        <div>
            <div class="section-title text-lg font-bold text-gray-900">
                Home Content Editor
            </div>
            <div class="section-sub text-sm text-gray-500">
                Kelola konten hero section dan informasi kontak landing page
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">
            💾 Simpan Semua Perubahan
        </button>
    </div>

    @if(session('success'))
        <div class="mb-5 p-4 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="mb-5 p-4 rounded-lg bg-red-100 text-red-700">
            <ul class="list-disc pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-5 mb-5">

        <!-- Hero Section -->
        <div class="card p-6">
            <div class="font-bold text-base mb-4 text-gray-900">
                🦸 Hero Section
            </div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    Eyebrow / Tagline Kecil
                </label>
                <input
                    type="text"
                    name="tagline"
                    class="inp"
                    value="{{ old('tagline', $home->tagline) }}"
                    placeholder="Tagline kecil di atas judul"
                >
            </div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    Judul Utama (H1)
                </label>
                <input
                    type="text"
                    name="judul"
                    class="inp"
                    value="{{ old('judul', $home->judul) }}"
                    placeholder="Judul utama hero"
                >
            </div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    Deskripsi Hero
                </label>

                <textarea
                    name="deskripsi"
                    class="inp"
                    style="min-height:100px"
                    placeholder="Deskripsi hero"
                >{{ old('deskripsi', $home->deskripsi) }}</textarea>
            </div>

        </div>

    </div>

    <!-- Social Media Links
    <div class="card mb-5 p-6">

        <div class="font-bold mb-4 text-gray-900">
            🔗 Social Media & Kontak
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3.5">

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    📸 Instagram URL
                </label>

                <input
                    type="url"
                    name="ig_link"
                    class="inp"
                    value="{{ old('ig_link', $home->ig_link) }}"
                    placeholder="https://instagram.com/..."
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    💼 LinkedIn URL
                </label>

                <input
                    type="url"
                    name="linkedin_link"
                    class="inp"
                    value="{{ old('linkedin_link', $home->linkedin_link) }}"
                    placeholder="https://linkedin.com/..."
                >
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3.5">

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    ▶️ YouTube URL
                </label>

                <input
                    type="url"
                    name="yt_link"
                    class="inp"
                    value="{{ old('yt_link', $home->yt_link) }}"
                    placeholder="https://youtube.com/..."
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    🎵 TikTok URL
                </label>

                <input
                    type="url"
                    name="tt_link"
                    class="inp"
                    value="{{ old('tt_link', $home->tt_link) }}"
                    placeholder="https://tiktok.com/..."
                >
            </div>

        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    📧 Email Kontak
                </label>

                <input
                    type="email"
                    name="email"
                    class="inp"
                    value="{{ old('email', $home->email) }}"
                    placeholder="email@domain.com"
                >
            </div>

            <div>
                <label class="block text-xs font-semibold text-gray-500 mb-1">
                    📱 WhatsApp / HP
                </label>

                <input
                    type="text"
                    name="whatsapp"
                    class="inp"
                    value="{{ old('whatsapp', $home->whatsapp) }}"
                    placeholder="08xxxxxxxxxx"
                >
            </div>

        </div>

    </div> -->

</form>

@endsection

@push('styles')
<style>
.modal-overlay.open {
    display: flex !important;
}
</style>
@endpush