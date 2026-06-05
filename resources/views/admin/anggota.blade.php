@extends('layouts.admin')

@section('page-title', 'Manajemen Anggota')
@section('page-breadcrumb', 'Kelola Data Anggota')

@section('content')
<div class="section-header flex items-center justify-between mb-6 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Manajemen Anggota</div>
        <div class="section-sub text-sm text-gray-500">Total {{ number_format($totalAnggota, 0, ',', '.') }} anggota terdaftar</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <form action="{{ route('admin.anggota') }}" method="GET" class="flex gap-2 flex-wrap">
            <div class="search-bar relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm pointer-events-none">🔍</span>
                <input name="search" class="inp inp-sm pl-9 hover:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all shadow-sm" placeholder="Cari anggota..." value="{{ $search }}">
            </div>
            <select name="role" class="inp inp-sm w-auto hover:border-blue-400 focus:ring-2 focus:ring-blue-100 transition-all cursor-pointer shadow-sm" onchange="this.form.submit()">
                <option value="">Semua Role</option>
                <option value="ipb" @selected($role === 'ipb')>IPB</option>
                <option value="umum" @selected($role === 'umum')>Umum</option>
            </select>
            <button class="btn btn-outline btn-sm" type="submit">Cari</button>
        </form>
        <button class="btn btn-primary btn-sm hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300" onclick="openAddModal()">+ Tambah</button>
    </div>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-4 text-sm">
        {{ $errors->first() }}
    </div>
@endif

<div class="card overflow-hidden hover:shadow-lg transition-shadow duration-300">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Nama</th>
                    <th class="px-4 py-3">Username</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Role</th>
                    <th class="px-4 py-3">Tanggal Daftar</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota as $item)
                    @php
                        $roleLabel = $item->role === 'ipb' ? 'IPB' : 'Umum';
                        $roleClass = $item->role === 'ipb' ? 'bg-blue-100 text-blue-800' : 'bg-emerald-100 text-emerald-800';
                    @endphp
                    <tr class="border-b border-gray-50 hover:bg-blue-50 transition-colors duration-200 group">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-2.5">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-blue-400 flex items-center justify-center text-white font-bold text-xs shrink-0 group-hover:shadow-md transition-all duration-300 overflow-hidden">
                                    @if($item->profile_photo_url)
                                        <img src="{{ $item->profile_photo_url }}" alt="{{ $item->name }}" class="w-full h-full object-cover">
                                    @else
                                        {{ $item->initials }}
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900 group-hover:text-blue-700 transition-colors">{{ $item->name }}</div>
                                    <div class="text-[0.72rem] text-gray-500">ID #{{ $item->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3 font-mono text-[0.8rem] text-gray-700">{{ $item->username }}</td>
                        <td class="px-4 py-3 text-[0.85rem] text-gray-700">{{ $item->email }}</td>
                        <td class="px-4 py-3"><span class="{{ $roleClass }} px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">{{ $roleLabel }}</span></td>
                        <td class="px-4 py-3 text-[0.85rem] text-gray-700">{{ $item->created_at?->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-right whitespace-nowrap">
                            <button class="btn btn-ghost btn-icon btn-sm text-blue-600 hover:bg-blue-100" onclick='openEditModal(@json($item))'>✏️</button>
                            <button type="button" class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1 hover:bg-red-100" onclick="openDeleteModal('{{ $item->id }}', @js($item->name))">🗑️</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada anggota ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($anggota->hasPages())
        <div class="px-4 py-3 border-t border-gray-100">
            {{ $anggota->links() }}
        </div>
    @endif
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-anggota">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-md relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900" id="modal-title">Tambah Anggota</div>
            <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeModal('modal-anggota')">✕</button>
        </div>

        <form id="anggota-form" action="{{ route('admin.anggota.store') }}" method="POST">
            @csrf
            <div id="method-container"></div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama*</label>
                <input type="text" name="name" id="input-name" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Username*</label>
                <input type="text" name="username" id="input-username" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Email*</label>
                <input type="email" name="email" id="input-email" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Role*</label>
                <select name="role" id="input-role" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm bg-white cursor-pointer" required>
                    <option value="ipb">IPB</option>
                    <option value="umum">Umum</option>
                </select>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Password*</label>
                    <input type="password" name="password" id="input-password" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" minlength="8">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Konfirmasi Password*</label>
                    <input type="password" name="password_confirmation" id="input-password-confirmation" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" minlength="8">
                </div>
            </div>
            <p class="text-[0.72rem] text-gray-500 mt-2" id="password-note">Minimal 8 karakter.</p>

            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-anggota')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete">
    <div class="modal bg-white rounded-2xl p-6 w-full max-w-sm relative shadow-xl">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">⚠️</div>
            <div class="text-base font-bold text-gray-900 mb-1">Konfirmasi Hapus</div>
            <p class="text-xs text-gray-500 leading-relaxed px-2">
                Hapus anggota <strong id="delete-target-name" class="text-gray-800 font-semibold">-</strong>?
            </p>
        </div>

        <form id="delete-anggota-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" class="btn btn-ghost w-1/2 justify-center" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white rounded-xl px-4 py-2 text-sm font-semibold transition w-1/2 justify-center shadow-sm">Ya, Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.modal-overlay.open {
    display: flex !important;
}
</style>
@endpush

@push('scripts')
<script>
const modalAnggota = document.getElementById('modal-anggota');
const anggotaForm = document.getElementById('anggota-form');
const methodContainer = document.getElementById('method-container');
const modalTitle = document.getElementById('modal-title');
const btnSubmit = document.getElementById('btn-submit');
const passwordNote = document.getElementById('password-note');
const passwordInput = document.getElementById('input-password');
const passwordConfirmationInput = document.getElementById('input-password-confirmation');
const deleteAnggotaForm = document.getElementById('delete-anggota-form');
const deleteTargetName = document.getElementById('delete-target-name');

function openAddModal() {
    modalTitle.textContent = 'Tambah Anggota';
    anggotaForm.action = "{{ route('admin.anggota.store') }}";
    methodContainer.innerHTML = '';
    anggotaForm.reset();
    passwordInput.required = true;
    passwordConfirmationInput.required = true;
    passwordNote.textContent = 'Minimal 8 karakter.';
    btnSubmit.textContent = 'Simpan';
    modalAnggota.classList.add('open');
}

function openEditModal(item) {
    modalTitle.textContent = 'Edit Anggota';
    anggotaForm.action = `/admin/anggota/${item.id}`;
    methodContainer.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('input-name').value = item.name ?? '';
    document.getElementById('input-username').value = item.username ?? '';
    document.getElementById('input-email').value = item.email ?? '';
    document.getElementById('input-role').value = item.role ?? 'umum';
    passwordInput.value = '';
    passwordConfirmationInput.value = '';
    passwordInput.required = false;
    passwordConfirmationInput.required = false;
    passwordNote.textContent = 'Kosongkan jika tidak ingin mengganti password.';
    btnSubmit.textContent = 'Perbarui';
    modalAnggota.classList.add('open');
}

function openDeleteModal(id, name) {
    deleteAnggotaForm.action = `/admin/anggota/${id}`;
    deleteTargetName.textContent = `"${name}"`;
    document.getElementById('modal-delete').classList.add('open');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.remove('open');
}
</script>
@endpush
