@extends('layouts.admin')

@section('page-title', 'Manajemen FAQ')
@section('page-breadcrumb', 'Kelola Tanya Jawab')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Manajemen FAQ</div>
        <div class="section-sub text-sm text-gray-500">Kelola pertanyaan yang sering diajukan di website</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <button class="btn btn-primary btn-sm" onclick="openAddModal()">+ Tambah FAQ</button>
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
                    <th class="px-4 py-3">Pertanyaan</th>
                    <th class="px-4 py-3">Jawaban</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($faqs as $item)
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900 font-semibold">{{ $item->pertanyaan }}</td>
                    <td class="px-4 py-3 text-[0.78rem] text-gray-700 max-w-xs truncate">{{ $item->jawaban }}</td>
                    <td class="px-4 py-3 text-right whitespace-nowrap">
                        {{-- Tombol Edit --}}
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600" 
                                onclick="openEditModal('{{ $item->id }}', '{{ addslashes($item->pertanyaan) }}', '{{ addslashes($item->jawaban) }}')">
                            ✏️
                        </button>
                        
                        {{-- Tombol Hapus (Sekarang memicu Modal) --}}
                        <button type="button" class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1" 
                                onclick="openDeleteModal('{{ $item->id }}', '{{ addslashes($item->pertanyaan) }}')">
                            🗑️
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" class="px-4 py-8 text-center text-gray-500">Belum ada data FAQ.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ========================================= --}}
{{-- MODAL FORM (UNTUK TAMBAH & EDIT)          --}}
{{-- ========================================= --}}
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-faq">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900" id="modal-title">Tambah FAQ</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeModal('modal-faq')">✕</button>
        </div>
        
        <form id="faq-form" action="{{ route('faq.store') }}" method="POST">
            @csrf
            <div id="method-container"></div>

            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Pertanyaan*</label>
                <input type="text" name="pertanyaan" id="input-pertanyaan" class="inp w-full p-2 border border-gray-300 rounded-lg" placeholder="Masukkan pertanyaan yang sering diajukan" required>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Jawaban*</label>
                <textarea name="jawaban" id="input-jawaban" class="inp w-full p-2 border border-gray-300 rounded-lg" placeholder="Masukkan jawaban untuk pertanyaan ini" rows="4" required></textarea>
            </div>
            
            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="closeModal('modal-faq')">Batal</button>
                <button type="submit" class="btn btn-primary" id="btn-submit">📊 Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ========================================= --}}
{{-- MODAL KONFIRMASI HAPUS (GLOBAL)           --}}
{{-- ========================================= --}}
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete">
    <div class="modal bg-white rounded-2xl p-6 w-full max-w-md relative">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-100 text-red-600 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                ⚠️
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-2">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-500 mb-1">Apakah Anda yakin ingin menghapus FAQ berikut?</p>
            <p class="text-sm font-semibold text-gray-800 italic mb-6 bg-gray-50 p-2.5 rounded-lg border border-gray-100" id="delete-target-name"></p>
        </div>

        {{-- Form action di-inject via JavaScript --}}
        <form id="delete-faq-form" action="" method="POST">
            @csrf
            @method('DELETE')
            <div class="flex justify-end gap-2.5 pt-2 border-t border-gray-100">
                <button type="button" class="btn btn-ghost w-full sm:w-auto" onclick="closeModal('modal-delete')">Batal</button>
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-semibold px-4 py-2 rounded-lg text-sm transition w-full sm:w-auto">Hapus Data</button>
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
    // Ambil element pendukung modal Form
    const modalFaq = document.getElementById('modal-faq');
    const modalTitle = document.getElementById('modal-title');
    const faqForm = document.getElementById('faq-form');
    const methodContainer = document.getElementById('method-container');
    const inputPertanyaan = document.getElementById('input-pertanyaan');
    const inputJawaban = document.getElementById('input-jawaban');
    const btnSubmit = document.getElementById('btn-submit');

    // Ambil element pendukung modal Delete
    const modalDelete = document.getElementById('modal-delete');
    const deleteFaqForm = document.getElementById('delete-faq-form');
    const deleteTargetName = document.getElementById('delete-target-name');

    // 1. Buka Modal Tambah Data
    function openAddModal() {
        modalTitle.textContent = "Tambah FAQ";
        faqForm.action = "{{ route('faq.store') }}";
        methodContainer.innerHTML = ""; 
        inputPertanyaan.value = "";
        inputJawaban.value = "";
        btnSubmit.textContent = "📊 Simpan";
        modalFaq.classList.add('open');
    }

    // 2. Buka Modal Edit Data
    function openEditModal(id, pertanyaan, jawaban) {
        modalTitle.textContent = "Edit FAQ";
        faqForm.action = `/admin/faq/${id}`; 
        methodContainer.innerHTML = `<input type="hidden" name="_method" value="PUT">`; 
        inputPertanyaan.value = pertanyaan;
        inputJawaban.value = jawaban;
        btnSubmit.textContent = "💾 Perbarui";
        modalFaq.classList.add('open');
    }

    // 3. Buka Modal Konfirmasi Hapus Data
    function openDeleteModal(id, pertanyaan) {
        // Atur agar action form mengarah ke endpoint destruksi item target
        deleteFaqForm.action = `/admin/faq/${id}`;
        // Tampilkan teks pertanyaan yang akan dihapus ke user
        deleteTargetName.textContent = `"${pertanyaan}"`;
        modalDelete.classList.add('open');
    }

    // 4. Fungsi Tutup Modal Global (Menerima parameter ID modal target)
    function closeModal(modalId) {
        document.getElementById(modalId).classList.remove('open');
    }
</script>
@endpush