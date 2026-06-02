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

    
    <!-- Keamanan Akun -->
    <div class="card p-6">
        <div class="font-bold text-base mb-4 text-gray-900">🔐 Keamanan Akun</div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Name</label>
            <input class="inp" value="user_kspm">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Username</label>
            <input class="inp" value="username_kspm">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Email</label>
            <input class="inp" value="email_kspm">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Password Baru</label>
            <input class="inp" type="password" placeholder="••••••••">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Konfirmasi Password</label>
            <input class="inp" type="password" placeholder="••••••••">
        </div>
        
        <div class="mt-5">
            <button class="btn btn-warn bg-amber-500 hover:bg-amber-600 text-white" onclick="alert('Password berhasil diubah!')">🔒 Ubah Password</button>
        </div>
    </div>
@endsection