@extends('layouts.user')

@section('page-title', 'Riset & Publikasi')
@section('page-breadcrumb', 'Manajemen Dokumen')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Riset & Publikasi</div>
        <div class="section-sub text-sm text-gray-500">Kelola dokumen riset KSPM</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <div class="search-bar relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input id="search-riset" class="inp inp-sm pl-9" placeholder="Cari riset..." onkeyup="filterRisetTable()">
        </div>
        <select id="filter-kategori" class="inp inp-sm" style="width:auto" onchange="filterRisetTable()">
            <option value="">Semua Kategori</option>
            <option value="weekly">Weekly Outlook</option>
            <option value="fundamental">Analisis Fundamental</option>
            <option value="stock">Stock Pick</option>
            <option value="outlook">Outlook Sektor</option>
            <option value="khusus">Riset Khusus</option>
        </select>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Judul</th>
                    <th class="px-4 py-3">Kategori</th>
                    <th class="px-4 py-3">Penulis</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body-riset">
                @forelse($reports as $report)
                    <tr class="riset-row border-b border-gray-50 hover:bg-blue-50 transition"
                        data-judul="{{ Str::lower($report->judul_riset) }}"
                        data-kategori="{{ Str::lower($report->kategori) }}">
                        <td class="px-4 py-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-12 rounded-lg bg-red-100 flex flex-col items-center justify-center text-[0.6rem] font-extrabold text-red-800 shrink-0"><span>📄</span><span>PDF</span></div>
                                <a href="{{ asset($report->pdf_file) }}" download class="font-semibold text-[0.85rem] text-gray-900 hover:text-blue-600">{{ $report->judul_riset }}</a>
                            </div>
                        </td>
                        <td class="px-4 py-3"><span class="bg-blue-100 text-blue-800 px-2.5 py-0.5 rounded-full text-xs font-semibold">{{ ucfirst($report->kategori) }}</span></td>
                        <td class="px-4 py-3 text-[0.82rem] text-gray-900">{{ $report->penulis ?: '-' }}</td>
                        <td class="px-4 py-3 font-mono text-[0.78rem] text-gray-700">{{ $report->tanggal_rilis ?: '-' }}</td>
                        <td class="px-4 py-3"><span class="bg-{{ $report->status === 'publik' ? 'green' : ($report->status === 'draft' ? 'orange' : 'gray') }}-100 text-{{ $report->status === 'publik' ? 'green' : ($report->status === 'draft' ? 'orange' : 'gray') }}-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">{{ ucfirst($report->status) }}</span></td>
                        <td class="px-4 py-3 text-right">
                            <a href="{{ asset($report->pdf_file) }}" download class="btn btn-sm btn-primary">Unduh</a>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Belum ada laporan riset.</td>
                    </tr>
                @endforelse
                
                <tr id="no-match-row" class="hidden">
                    <td colspan="6" class="px-4 py-8 text-center text-gray-400">Tidak ada dokumen riset yang cocok dengan kriteria pencarian.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }
</style>
@endpush

@push('scripts')
<script>
/**
 * Fungsi Pencarian & Penyaringan Real-Time (Sisi Klien)
 */
function filterRisetTable() {
    // Mengambil value string dari input pencarian dan select option filter
    const keyword = document.getElementById('search-riset').value.toLowerCase().trim();
    const kategoriFilter = document.getElementById('filter-kategori').value.toLowerCase();
    
    // Memilih semua baris tabel riset yang memiliki kelas '.riset-row'
    const rows = document.querySelectorAll('.riset-row');
    const noMatchRow = document.getElementById('no-match-row');
    let matchedCount = 0;

    rows.forEach(row => {
        // Mengambil isi data-attributes string dari tag <tr>
        const judulRiset = row.getAttribute('data-judul') || '';
        const kategoriRiset = row.getAttribute('data-kategori') || '';

        // Menentukan kecocokan kondisi filter kombinasi
        const cocokKataKunci = judulRiset.includes(keyword);
        const cocokKategori = (kategoriFilter === '') || (kategoriRiset === kategoriFilter);

        if (cocokKataKunci && cocokKategori) {
            row.classList.remove('hidden');
            matchedCount++;
        } else {
            row.classList.add('hidden');
        }
    });

    // Menampilkan pesan umpan balik "tidak ada kecocokan data" jika baris terfilter bernilai kosong
    if (noMatchRow) {
        if (matchedCount === 0 && rows.length > 0) {
            noMatchRow.classList.remove('hidden');
        } else {
            noMatchRow.classList.add('hidden');
        }
    }
}

/**
 * Membuka modal konfirmasi hapus dan menyuntikkan data tujuan form secara dinamis
 * @param {string} id - ID data dari database
 * @param {string} judul - Judul dokumen riset
 */
function openDeleteModal(id, judul) {
    const deleteUrl = "{{ route('admin.riset.destroy', ':id') }}".replace(':id', id);
    
    document.getElementById('form-delete-riset').setAttribute('action', deleteUrl);
    document.getElementById('delete-target-title').textContent = '"' + judul + '"';
    document.getElementById('modal-delete-riset').classList.add('open');
}

/**
 * Menutup modal konfirmasi hapus
 */
function closeDeleteModal() {
    document.getElementById('modal-delete-riset').classList.remove('open');
}
</script>
@endpush