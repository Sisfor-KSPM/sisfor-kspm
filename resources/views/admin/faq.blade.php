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
        <button class="btn btn-primary btn-sm" onclick="document.getElementById('modal-riset').classList.add('open')">+ Tambah FAQ</button>
    </div>
</div>

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
                <!-- Riset Row 1 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">KSPM Research Team</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-02-17</td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>

                <!-- Riset Row 1 -->
                <tr class="border-b border-gray-50 hover:bg-blue-50 transition">
                    <td class="px-4 py-3 text-[0.82rem] text-gray-900">KSPM Research Team</td>
                    <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">2025-02-17</td>
                    <td class="px-4 py-3 text-right">
                        <button class="btn btn-ghost btn-icon btn-sm text-blue-600">✏️</button>
                        <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1">🗑️</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!-- MODAL Tambah FAQ -->
<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-riset">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-lg max-h-[90vh] overflow-y-auto relative">
        <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
            <div class="modal-title text-base font-bold text-gray-900">Tambah FAQ</div>
            <button class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="document.getElementById('modal-riset').classList.remove('open')">✕</button>
        </div>
        
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Pertanyaan*</label>
            <input class="inp" placeholder="Masukkan pertanyaan yang sering diajukan">
        </div>
        <div class="mb-3.5">
            <label class="block text-xs font-semibold text-gray-500 mb-1">Jawaban*</label>
            <textarea class="inp" placeholder="Masukkan jawaban untuk pertanyaan ini" rows="4"></textarea>
        </div>
        
        <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
            <button class="btn btn-ghost" onclick="document.getElementById('modal-riset').classList.remove('open')">Batal</button>
            <button class="btn btn-primary" onclick="alert('Riset disimpan!'); document.getElementById('modal-riset').classList.remove('open')">📊 Simpan</button>
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