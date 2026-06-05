@extends('layouts.user')

@section('page-title', 'Pengaturan')
@section('page-breadcrumb', 'Konfigurasi Sistem')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Pengaturan</div>
        <div class="section-sub text-sm text-gray-500">Konfigurasi sistem dashboard</div>
    </div>
</div>

@if (session('success'))
    <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700 text-sm font-medium">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded-lg text-red-600 text-sm font-medium">
        <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card p-6">
    <div class="font-bold text-base mb-4 text-gray-900">🔐 Keamanan Akun</div>
    
    {{-- Form mengarah ke route update data --}}
    <form action="{{ route('user.pengaturan.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Name</label>
            {{-- value menggunakan old() agar jika error, ketikan tidak hilang --}}
            <input class="inp w-full" name="name" value="{{ old('name', auth()->user()->name) }}" required>
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Username</label>
            <input class="inp w-full" name="username" value="{{ old('username', auth()->user()->username) }}" required>
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
            <input class="inp w-full" type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required>
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">
                Password Baru <span class="text-gray-400 font-normal">(Kosongkan jika tidak ingin mengubah password)</span>
            </label>
            <input class="inp w-full" type="password" name="password" placeholder="••••••••">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Konfirmasi Password Baru</label>
            <input class="inp w-full" type="password" name="password_confirmation" placeholder="••••••••">
        </div>
        
        <div class="mt-5">
            {{-- Tombol diubah menjadi tipe submit dan teks diubah --}}
            <button type="submit" class="btn btn-warn bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded">
                💾 Ubah Data
            </button>
        </div>
    </form>
</div>
@endsection