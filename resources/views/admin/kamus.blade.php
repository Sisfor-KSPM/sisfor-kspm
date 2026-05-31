@extends('layouts.admin')

@section('page-title', 'Kamus Investasi')
@section('page-breadcrumb', 'Manajemen Istilah')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Kamus Investasi</div>
        <div class="section-sub text-sm text-gray-500">Kelola istilah-istilah pasar modal</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <form action="{{ url()->current() }}" method="GET" class="search-bar relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input name="search" class="inp inp-sm pl-9" placeholder="Cari istilah..." value="{{ $search ?? '' }}">
        </form>
        <button class="btn btn-primary btn-sm" onclick="openAddModal()">+ Tambah Istilah</button>
    </div>
</div>

{{-- ALERT NOTIFIKASI --}}
@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Istilah</th>
                    <th class="px-4 py-3">Definisi</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($terms as $item)
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3 font-bold text-blue-700">{{ $item->istilah }}</td>
                    <td class="px-4 py-3 text-[0.83rem] text-gray-500 leading-relaxed max-w-md">{{ $item->definisi }}</td>
                    <td class="px-4 py-3">
                        @php
                            // Mengatur warna badge dinamis berdasarkan kategori
                            $colorMap = [
                                'Fundamental' => 'bg-orange-100 text-orange-800',
                                'Teknikal' => 'bg-blue-100 text-blue-800',
                                'Umum' => 'bg-gray-100 text-gray-600',
                                'Obligasi' => 'bg-purple-100 text-purple-800',
                                'Reksa Dana' => 'bg-green-100 text-green-800',
                            ];
                            $badgeClass = $colorMap[$item->kategori] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="{{ $badgeClass }} px-2.5 py-0.5 rounded-full text-xs font-semibold">
                            {{ $item->kategori }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600" 
                                onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->istilah) }}', '{{ addslashes($item->definisi) }}', '{{ $item->kategori }}')">
                            ✏️
                        </button>
                        <button type="button" class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1" 
                                onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->istilah) }}')">
                            🗑️
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada istilah investasi ditemukan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-kamus">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-md relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900" id="modal-title">Tambah Istilah</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeModal('modal-kamus')">✕</button>
        </div>
        
        <form id="kamus-form" action="{{ route('kamus.store') }}" method="POST">
            @csrf
            <div id="method-container"></div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Istilah*</label>
                <input type="text" name="istilah" id="input-istilah" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" placeholder="Nama istilah investasi" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Definisi*</label>
                <textarea name="definisi" id="input-definisi" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm" rows="3" placeholder="Penjelasan singkat dan jelas..." required></textarea>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Kategori</label>
                <select name="kategori" id="input-kategori" class="inp w-full p-2 border border-gray-300 rounded-lg text-sm bg-white cursor-pointer">
                    <option value="Fundamental">Fundamental</option>
                    <option value="Teknikal">Teknikal</option>
                    <option value="Umum">Umum</option>
                    <option value="Obligasi">Obligasi</option>
                    <option value="Reksa Dana">Reksa Dana</option>
                </select>
            </div>
            
            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-kamus')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">📖 Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete">
    <div class="modal bg-white rounded-2xl p-6 w-full max-w-md relative">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">⚠️</div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Hapus Istilah</h3>
            <p class="text-sm text-gray-500 mb-1">Apakah Anda yakin ingin menghapus istilah berikut dari kamus?</p>
            <p class="text-sm font-semibold text-gray-800 italic mb-6 bg-gray-50 p-2 rounded border border-gray-100" id="delete-target-name"></p>
        </div>

        <form id="delete-kamus-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2.5 pt-2 border-t border-gray-100">
                <button type="button" class="btn btn-ghost w-full sm:w-auto" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition w-full sm:w-auto">Konfirmasi Hapus</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.modal-overlay.open { display: flex !important; }
</style>
@endpush

@push('scripts')
<script>
    const modalKamus = document.getElementById('modal-kamus');
    const modalTitle = document.getElementById('modal-title');
    const kamusForm = document.getElementById('kamus-form');
    const methodContainer = document.getElementById('method-container');
    const inputIstilah = document.getElementById('input-istilah');
    const inputDefinisi = document.getElementById('input-definisi');
    const inputKategori = document.getElementById('input-kategori');
    const btnSubmit = document.getElementById('btn-submit');

    const modalDelete = document.getElementById('modal-delete');
    const deleteKamusForm = document.getElementById('delete-kamus-form');
    const deleteTargetName = document.getElementById('delete-target-name');

    function openAddModal() {
        modalTitle.textContent = "Tambah Istilah";
        kamusForm.action = "{{ route('kamus.store') }}";
        methodContainer.innerHTML = ""; 
        inputIstilah.value = "";
        inputDefinisi.value = "";
        inputKategori.value = "Fundamental";
        btnSubmit.textContent = "📖 Simpan";
        modalKamus.classList.add('open');
    }

    function openEditModal(id, istilah, definisi, kategori) {
        modalTitle.textContent = "Edit Istilah";
        kamusForm.action = `/admin/kamus/${id}`; // Sesuaikan URL prefix routing web Anda
        methodContainer.innerHTML = `<input type="hidden" name="_method" value="PUT">`; 
        inputIstilah.value = istilah;
        inputDefinisi.value = definisi;
        inputKategori.value = kategori;
        btnSubmit.textContent = "💾 Perbarui";
        modalKamus.classList.add('open');
    }

    function openDeleteModal(id, istilah) {
        deleteKamusForm.action = `/admin/kamus/${id}`; // Sesuaikan URL prefix routing web Anda
        deleteTargetName.textContent = `"${istilah}"`;
        modalDelete.classList.add('open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('open');
    }
</script>
@endpush