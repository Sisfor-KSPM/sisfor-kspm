@extends('layouts.user')

@section('page-title', 'Kamus Investasi')
@section('page-breadcrumb', 'Manajemen Istilah')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Kamus Investasi</div>
        <div class="section-sub text-sm text-gray-500">Kelola istilah-istilah pasar modal</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        {{-- KUNCI 1: Form dipertahankan jika user menekan Enter, input diberi penanda JavaScript --}}
        <form action="{{ url()->current() }}" method="GET" class="search-bar relative" onsubmit="event.preventDefault();">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input id="kamus-search-input" class="inp inp-sm pl-9" placeholder="Cari istilah..." value="{{ request('search') }}">
        </form>
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
                </tr>
            </thead>
            <tbody id="kamus-table-body">
                @forelse($terms as $item)
                {{-- KUNCI 2: Tambahkan class kamus-row untuk mempermudah tracking JavaScript --}}
                <tr class="kamus-row border-b border-gray-50 hover:bg-blue-50 transition cursor-pointer" data-track-dictionary="{{ $item->id }}" data-track-title="{{ $item->istilah }}">
                    <td class="px-4 py-3 font-bold text-blue-700 term-name">{{ $item->istilah }}</td>
                    <td class="px-4 py-3 text-[0.83rem] text-gray-500 leading-relaxed max-w-md term-definition">{{ $item->definisi }}</td>
                    <td class="px-4 py-3">
                        @php
                            $colorMap = [
                                'Fundamental' => 'bg-orange-100 text-orange-800',
                                'Teknikal' => 'bg-blue-100 text-blue-800',
                                'Umum' => 'bg-gray-100 text-gray-600',
                                'Obligasi' => 'bg-purple-100 text-purple-800',
                                'Reksa Dana' => 'bg-green-100 text-green-800',
                            ];
                            $badgeClass = $colorMap[$item->kategori] ?? 'bg-gray-100 text-gray-600';
                        @endphp
                        <span class="{{ $badgeClass }} px-2.5 py-0.5 rounded-full text-xs font-semibold term-category">
                            {{ $item->kategori }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr id="initial-empty-row">
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Tidak ada istilah investasi ditemukan.</td>
                </tr>
                @endforelse
                
                {{-- Baris dinamis yang muncul jika hasil pencarian lokal tidak ditemukan --}}
                <tr id="no-search-results" class="hidden">
                    <td colspan="4" class="px-4 py-8 text-center text-gray-500">Istilah yang Anda cari tidak ditemukan.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
/* KUNCI 3: Aturan utilitas visual modal dan penyembunyian baris tabel */
.modal-overlay.open { 
    display: flex !important; 
}
.kamus-row.is-hidden {
    display: none !important;
}
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

    // KUNCI 4: Inisialisasi Fungsi Pencarian Kamus Real-Time
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('kamus-search-input');
        const rows = document.querySelectorAll('.kamus-row');
        const noResultsRow = document.getElementById('no-search-results');
        const initialEmptyRow = document.getElementById('initial-empty-row');

        if (searchInput) {
            searchInput.addEventListener('input', function() {
                const query = this.value.trim().toLowerCase();
                let visibleCount = 0;

                rows.forEach(row => {
                    const istilahText = row.querySelector('.term-name')?.innerText.toLowerCase() || '';
                    const definisiText = row.querySelector('.term-definition')?.innerText.toLowerCase() || '';
                    const kategoriText = row.querySelector('.term-category')?.innerText.toLowerCase() || '';

                    // Jika keyword cocok dengan nama istilah, arti definisi, atau kategori badge
                    if (query === '' || istilahText.includes(query) || definisiText.includes(query) || kategoriText.includes(query)) {
                        row.classList.remove('is-hidden');
                        visibleCount++;
                    } else {
                        row.classList.add('is-hidden');
                    }
                });

                // Atur visibility alert jika pencarian tidak membuahkan hasil
                if (rows.length > 0 && noResultsRow) {
                    if (visibleCount === 0) {
                        noResultsRow.classList.remove('hidden');
                    } else {
                        noResultsRow.classList.add('hidden');
                    }
                }
            });
        }

        rows.forEach(row => {
            row.addEventListener('click', function() {
                if (window.AnalyticsTracker) {
                    AnalyticsTracker.trackDictionary(this.dataset.trackDictionary, this.dataset.trackTitle);
                }
            });
        });
    });

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
        kamusForm.action = `/admin/kamus/${id}`; 
        methodContainer.innerHTML = `<input type="hidden" name="_method" value="PUT">`; 
        inputIstilah.value = istilah;
        inputDefinisi.value = definisi;
        inputKategori.value = kategori;
        btnSubmit.textContent = "💾 Perbarui";
        modalKamus.classList.add('open');
    }

    function openDeleteModal(id, istilah) {
        deleteKamusForm.action = `/admin/kamus/${id}`; 
        deleteTargetName.textContent = `"${istilah}"`;
        modalDelete.classList.add('open');
    }

    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('open');
    }
</script>
@endpush
