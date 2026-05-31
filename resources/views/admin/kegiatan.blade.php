@extends('layouts.admin')

@section('page-title', 'Kegiatan & Event')
@section('page-breadcrumb', 'Kelola Agenda')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">Kegiatan & Event</div>
        <div class="section-sub text-sm text-gray-500">Kelola semua agenda KSPM</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <div class="search-bar relative">
            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
            <input id="search-kegiatan" class="inp inp-sm pl-9" placeholder="Cari kegiatan..." onkeyup="filterTable()">
        </div>
        <select id="filter-tipe" class="inp inp-sm" style="width:auto" onchange="filterTable()">
            <option value="">Semua Tipe</option>
            <option value="seminar">Seminar</option>
            <option value="workshop">Workshop</option>
            <option value="kompetisi">Lomba</option> <option value="rapat">Rapat</option>
            <option value="webinar">Webinar</option>
            <option value="company_visit">Company Visit</option>
        </select>
        <button class="btn btn-primary btn-sm" onclick="openTambahKegiatan()">+ Tambah Kegiatan</button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
    <div class="card p-5">
        <div class="flex items-center justify-between mb-4">
            <button class="btn btn-ghost btn-icon btn-sm">◀</button>
            <div class="font-bold text-[0.95rem]">Maret 2026</div>
            <button class="btn btn-ghost btn-icon btn-sm">▶</button>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center mb-1">
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Min</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Sen</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Sel</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Rab</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Kam</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Jum</div>
            <div class="text-[0.68rem] font-bold text-gray-500 uppercase py-1">Sab</div>
        </div>
        <div class="grid grid-cols-7 gap-1 text-center">
            <div></div><div></div><div></div><div></div><div></div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">1</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">2</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative">
                3
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm bg-blue-600 text-white font-bold cursor-pointer transition relative">
                4 
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative">
                5 <div class="absolute bottom-1 w-1 h-1 bg-sky-500 rounded-full"></div>
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">6</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">7</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">8</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">9</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative">
                10 <div class="absolute bottom-1 w-1 h-1 bg-sky-500 rounded-full"></div>
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">11</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">12</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">13</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">14</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative">
                15 <div class="absolute bottom-1 w-1 h-1 bg-sky-500 rounded-full"></div>
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">16</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">17</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">18</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">19</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">20</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">21</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative">
                22 <div class="absolute bottom-1 w-1 h-1 bg-sky-500 rounded-full"></div>
            </div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">23</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">24</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">25</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">26</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">27</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">28</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">29</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">30</div>
            <div class="aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition">31</div>
        </div>
    </div>

    <div class="card p-5">
        <div class="font-bold mb-3.5 text-gray-900">Kegiatan Mendatang</div>
        <div class="flex flex-col gap-2.5">
            @forelse($events->where('status', 'upcoming')->take(3) as $event)
                <div class="flex gap-3 p-2.5 rounded-xl border border-gray-200 hover:border-blue-500 transition">
                    <div class="text-center w-10 shrink-0 border-r border-gray-100 pr-2">
                        <div class="font-mono font-extrabold text-blue-600 text-lg">{{ \Carbon\Carbon::parse($event->tanggal)->format('d') }}</div>
                        <div class="text-[0.65rem] text-gray-500">{{ \Carbon\Carbon::parse($event->tanggal)->format('M') }}</div>
                    </div>
                    <div>
                        <div class="text-[0.85rem] font-semibold text-gray-900">{{ $event->kegiatan }}</div>
                        <div class="text-[0.72rem] text-gray-500 mt-0.5">{{ $event->waktu_mulai ?? '—' }} · {{ $event->tempat ?? 'TBD' }}</div>
                    </div>
                </div>
            @empty
                <div class="text-center py-4 text-gray-500 text-sm">Tidak ada kegiatan mendatang</div>
            @endforelse
        </div>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse text-sm">
            <thead>
                <tr class="text-gray-500 uppercase tracking-wider border-b border-gray-200 bg-gray-50">
                    <th class="px-4 py-3">Kegiatan</th>
                    <th class="px-4 py-3">Tipe</th>
                    <th class="px-4 py-3">Tanggal</th>
                    <th class="px-4 py-3">Waktu</th>
                    <th class="px-4 py-3">Tempat</th>
                    <th class="px-4 py-3">PIC</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody id="table-body-kegiatan">
                @forelse($events as $event)
                    <tr class="kegiatan-row border-b border-gray-50 hover:bg-blue-50 transition" 
                        data-nama="{{ Str::lower($event->kegiatan) }}" 
                        data-tipe="{{ Str::lower($event->tipe) }}">
                        <td class="px-4 py-3">
                            <div class="font-semibold text-gray-900 name-target">{{ $event->kegiatan }}</div>
                            <div class="text-[0.72rem] text-gray-500">{{ Str::limit($event->deskripsi ?? '-', 50) }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">
                                {{ ucfirst($event->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-[0.8rem]">{{ \Carbon\Carbon::parse($event->tanggal)->format('Y-m-d') }}</td>
                        <td class="px-4 py-3 text-[0.8rem]">{{ $event->waktu_mulai ?? '—' }}@if($event->waktu_selesai)–{{ $event->waktu_selesai }}@endif</td>
                        <td class="px-4 py-3 text-[0.82rem]">{{ $event->tempat ?? '-' }}</td>
                        <td class="px-4 py-3 text-[0.82rem]">{{ $event->pic ?? '-' }}</td>
                        <td class="px-4 py-3">
                            <span class="@if($event->status === 'upcoming') bg-blue-100 text-blue-800 @elseif($event->status === 'berlangsung') bg-yellow-100 text-yellow-800 @elseif($event->status === 'selesai') bg-green-100 text-green-800 @else bg-red-100 text-red-800 @endif px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">
                                {{ ucfirst($event->status) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 text-right">
                            <button class="btn btn-ghost btn-icon btn-sm text-blue-600" onclick="editKegiatan({{ $event->id }})">✏️</button>
                            <button class="btn btn-ghost btn-icon btn-sm text-red-500 ml-1" onclick="deleteKegiatan({{ $event->id }})">🗑️</button>
                        </td>
                    </tr>
                @empty
                    <tr id="empty-row">
                        <td colspan="8" class="text-center py-8 text-gray-400">Belum ada kegiatan</td>
                    </tr>
                @endforelse
                <tr id="no-match-row" class="hidden">
                    <td colspan="8" class="text-center py-8 text-gray-400">Tidak ada kegiatan yang cocok dengan pencarian.</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-kegiatan">
    <div class="modal bg-white rounded-2xl p-7 w-full max-w-2xl max-h-[90vh] overflow-y-auto relative">
        <form id="kegiatanForm" action="{{ route('kegiatan.store') }}" method="POST">
            @csrf
            <input type="hidden" id="kegiatanMethodField" name="_method" value="">

            <div class="modal-header flex items-center justify-between mb-5 pb-3.5 border-b border-gray-200">
                <div id="kegiatanModalTitle" class="modal-title text-base font-bold text-gray-900">Tambah Kegiatan</div>
                <button type="button" class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 hover:bg-red-100 hover:text-red-500 transition flex items-center justify-center" onclick="closeKegiatanModal()">✕</button>
            </div>
            
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Nama Kegiatan*</label>
                <input name="kegiatan" id="kegiatan_kegiatan" class="inp" placeholder="Nama kegiatan" required>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tipe*</label>
                    <select name="tipe" id="kegiatan_tipe" class="inp" required>
                        <option value="webinar">Webinar</option>
                        <option value="workshop">Workshop</option>
                        <option value="kompetisi">Kompetisi</option>
                        <option value="company_visit">Company Visit</option>
                        <option value="seminar">Seminar</option>
                        <option value="rapat">Rapat</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Tanggal*</label>
                    <input type="date" name="tanggal" id="kegiatan_tanggal" class="inp" required>
                </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Waktu Mulai</label><input type="time" name="waktu_mulai" id="kegiatan_waktu_mulai" class="inp"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Waktu Selesai</label><input type="time" name="waktu_selesai" id="kegiatan_waktu_selesai" class="inp"></div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Tempat</label><input name="tempat" id="kegiatan_tempat" class="inp" placeholder="Lokasi / Link Zoom"></div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">PIC / Penanggungjawab</label><input name="pic" id="kegiatan_pic" class="inp" placeholder="Nama PIC"></div>
            </div>
            <div class="mb-3.5">
                <label class="block text-xs font-semibold text-gray-500 mb-1">Deskripsi</label>
                <textarea name="deskripsi" id="kegiatan_deskripsi" class="inp" placeholder="Deskripsi singkat kegiatan..." rows="3"></textarea>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-3.5">
                <div>
                    <label class="block text-xs font-semibold text-gray-500 mb-1">Status</label>
                    <select name="status" id="kegiatan_status" class="inp">
                        <option value="upcoming">Upcoming</option>
                        <option value="berlangsung">Berlangsung</option>
                        <option value="selesai">Selesai</option>
                        <option value="dibatalkan">Dibatalkan</option>
                    </select>
                </div>
                <div><label class="block text-xs font-semibold text-gray-500 mb-1">Kuota Peserta</label><input type="number" name="kuota" id="kegiatan_kuota" class="inp" placeholder="50"></div>
            </div>

            <div class="mt-5 pt-4 border-t border-gray-200 flex justify-end gap-2.5">
                <button type="button" class="btn btn-ghost" onclick="closeKegiatanModal()">Batal</button>
                <button type="submit" class="btn btn-primary">💾 Simpan</button>
            </div>
        </form>
    </div>
</div>

<div class="modal-overlay fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4" id="modal-delete-kegiatan">
    <div class="modal bg-white rounded-2xl p-6 w-full max-w-sm relative shadow-xl">
        <div class="text-center">
            <div class="w-14 h-14 bg-red-50 text-red-500 rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">
                ⚠️
            </div>
            <div class="text-base font-bold text-gray-900 mb-1">Konfirmasi Hapus</div>
            <p class="text-xs text-gray-500 leading-relaxed px-2">
                Apakah Anda yakin ingin menghapus kegiatan <strong id="deleteKegiatanName" class="text-gray-800 font-semibold"></strong>? Tindakan ini tidak dapat dibatalkan.
            </p>
        </div>
        
        <form id="deleteKegiatanForm" action="" method="POST">
            @csrf
            @method('DELETE')
            
            <div class="mt-6 flex justify-center gap-3">
                <button type="button" class="btn btn-ghost w-1/2 justify-center" onclick="closeDeleteKegiatanModal()">
                    Batal
                </button>
                <button type="submit" class="btn bg-red-600 hover:bg-red-700 text-white rounded-xl px-4 py-2 text-sm font-semibold transition w-1/2 justify-center shadow-sm">
                    🗑️ Ya, Hapus
                </button>
            </div>
        </form>
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
 * Fungsi Pencarian & Penyaringan Real-Time (Client-Side)
 */
function filterTable() {
    const searchInput = document.getElementById('search-kegiatan').value.toLowerCase();
    const filterSelect = document.getElementById('filter-tipe').value.toLowerCase();
    const rows = document.querySelectorAll('.kegiatan-row');
    const noMatchRow = document.getElementById('no-match-row');
    let visibleCount = 0;

    rows.forEach(row => {
        const namaKegiatan = row.getAttribute('data-nama');
        const tipeKegiatan = row.getAttribute('data-tipe');

        // Validasi kecocokan data inputan search dan filter select
        const matchesSearch = namaKegiatan.includes(searchInput);
        const matchesFilter = filterSelect === "" || tipeKegiatan === filterSelect;

        if (matchesSearch && matchesFilter) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });

    // Handle tampilan jika tidak ada satupun row yang sesuai dengan filter
    if (noMatchRow) {
        if (visibleCount === 0 && rows.length > 0) {
            noMatchRow.classList.remove('hidden');
        } else {
            noMatchRow.classList.add('hidden');
        }
    }
}

function openTambahKegiatan()
{
    const form = document.getElementById('kegiatanForm');
    form.reset();
    form.action = "{{ route('kegiatan.store') }}";
    document.getElementById('kegiatanMethodField').value = '';
    document.getElementById('kegiatanModalTitle').innerText = 'Tambah Kegiatan';
    document.getElementById('modal-kegiatan').classList.add('open');
}

function closeKegiatanModal()
{
    document.getElementById('modal-kegiatan').classList.remove('open');
}

function editKegiatan(id)
{
    fetch('{{ url('/admin/kegiatan') }}/'+id+'/edit')
    .then(res => res.json())
    .then(data => {
        const form = document.getElementById('kegiatanForm');
        document.getElementById('kegiatanModalTitle').innerText = 'Edit Kegiatan';
        document.getElementById('kegiatan_kegiatan').value = data.kegiatan || '';
        document.getElementById('kegiatan_tipe').value = data.tipe || '';
        document.getElementById('kegiatan_tanggal').value = data.tanggal || '';
        document.getElementById('kegiatan_waktu_mulai').value = data.waktu_mulai || '';
        document.getElementById('kegiatan_waktu_selesai').value = data.waktu_selesai || '';
        document.getElementById('kegiatan_tempat').value = data.tempat || '';
        document.getElementById('kegiatan_pic').value = data.pic || '';
        document.getElementById('kegiatan_deskripsi').value = data.deskripsi || '';
        document.getElementById('kegiatan_status').value = data.status || 'upcoming';
        document.getElementById('kegiatan_kuota').value = data.kuota || '';

        form.action = '{{ url('/admin/kegiatan') }}/' + id;
        document.getElementById('kegiatanMethodField').value = 'PUT';
        document.getElementById('modal-kegiatan').classList.add('open');
    })
    .catch(err => { console.error(err); alert('Gagal mengambil data kegiatan'); });
}

function deleteKegiatan(id)
{
    fetch('{{ url('/admin/kegiatan') }}/'+id+'/edit')
    .then(res => res.json())
    .then(data => {
        document.getElementById('deleteKegiatanName').innerText = data.kegiatan || '-';
        document.getElementById('deleteKegiatanForm').action = '{{ url('/admin/kegiatan') }}/' + id;
        document.getElementById('modal-delete-kegiatan').classList.add('open');
    })
    .catch(err => { console.error(err); alert('Gagal mengambil data kegiatan'); });
}

function closeDeleteKegiatanModal()
{
    document.getElementById('modal-delete-kegiatan').classList.remove('open');
}
</script>
@endpush