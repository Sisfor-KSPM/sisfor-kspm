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
            <button class="btn btn-ghost btn-icon btn-sm" onclick="changeMonth(-1)">◀</button>
            <div id="calendar-month-year" class="font-bold text-[0.95rem]">Juni 2026</div>
            <button class="btn btn-ghost btn-icon btn-sm" onclick="changeMonth(1)">▶</button>
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
        <div id="calendar-days" class="grid grid-cols-7 gap-1 text-center">
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
                            <div class="text-[0.72rem] text-gray-500">{{ Str::limit(strip_tags($event->deskripsi ?? '-'), 50) }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <span class="bg-purple-100 text-purple-800 px-2.5 py-0.5 rounded-full text-[0.7rem] font-semibold">
                                {{ ucfirst($event->tipe) }}
                            </span>
                        </td>
                        <td class="px-4 py-3 font-mono text-[0.8rem])">{{ \Carbon\Carbon::parse($event->tanggal)->format('Y-m-d') }}</td>
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
                
                <input type="hidden" name="deskripsi" id="kegiatan_deskripsi">
                
                <trix-editor 
                    input="kegiatan_deskripsi" 
                    class="inp min-h-[120px] bg-white border border-gray-300 rounded-lg p-2 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                    placeholder="Deskripsi singkat kegiatan...">
                </trix-editor>
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
<link rel="stylesheet" type="text/css" href="https://unpkg.com/trix@2.0.8/dist/trix.css">
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }

/* CSS Kustomisasi Toolbar dan Editor Trix */
trix-toolbar .trix-button-group--file-tools {
    display: none !important;
}
trix-editor ul { list-style-type: disc !important; padding-left: 1rem !important; }
trix-editor ol { list-style-type: decimal !important; padding-left: 1rem !important; }
trix-editor a { color: #2563eb !important; text-decoration: underline !important; }
</style>
@endpush

@push('scripts')
<script type="text/javascript" src="https://unpkg.com/trix@2.0.8/dist/trix.umd.min.js"></script>
<script>
/**
 * Inisialisasi Data Agenda & Logika Kalender Dinamis
 */
// Melempar data events dari backend Laravel ke JavaScript secara aman
const agendaEvents = @json($events->map(function($item) {
    return [
        'tanggal' => \Carbon\Carbon::parse($item->tanggal)->format('Y-m-d'),
        'kegiatan' => $item->kegiatan
    ];
}));

let dateToday = new Date();
let currentMonth = dateToday.getMonth();
let currentYear = dateToday.getFullYear();

const namaBulan = [
    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
];

function renderCalendar() {
    const monthYearLabel = document.getElementById('calendar-month-year');
    const calendarDaysContainer = document.getElementById('calendar-days');
    
    // Update teks bulan dan tahun di header kalender
    monthYearLabel.innerText = `${namaBulan[currentMonth]} ${currentYear}`;
    
    // Bersihkan grid hari sebelumnya
    calendarDaysContainer.innerHTML = '';
    
    // Dapatkan indeks hari pertama bulan terpilih (0: Minggu, 1: Senin, dst)
    const firstDayIndex = new Date(currentYear, currentMonth, 1).getDay();
    
    // Dapatkan total hari pada bulan terpilih
    const totalDays = new Date(currentYear, currentMonth + 1, 0).getDate();
    
    // Buat elemen grid kosong untuk menyelaraskan hari pertama
    for (let i = 0; i < firstDayIndex; i++) {
        const emptyDiv = document.createElement('div');
        calendarDaysContainer.appendChild(emptyDiv);
    }
    
    // Render baris tanggal secara dinamis
    for (let day = 1; day <= totalDays; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.className = "aspect-square flex flex-col items-center justify-center rounded-lg text-sm hover:bg-blue-50 cursor-pointer transition relative";
        dayDiv.innerText = day;
        
        // Buat format YYYY-MM-DD untuk pencocokan agenda database
        const mmString = String(currentMonth + 1).padStart(2, '0');
        const ddString = String(day).padStart(2, '0');
        const formattedDate = `${currentYear}-${mmString}-${ddString}`;
        
        // Sorot jika tanggal adalah hari ini
        if (day === dateToday.getDate() && currentMonth === dateToday.getMonth() && currentYear === dateToday.getFullYear()) {
            dayDiv.className = "aspect-square flex flex-col items-center justify-center rounded-lg text-sm bg-blue-600 text-white font-bold cursor-pointer transition relative";
        }
        
        // Cek apakah tanggal ini memiliki agenda di database
        const hasAgenda = agendaEvents.some(event => event.tanggal === formattedDate);
        if (hasAgenda) {
            const dotPenanda = document.createElement('div');
            // Ganti warna dot menjadi putih jika bersentuhan dengan background biru "hari ini" agar kontras
            dotPenanda.className = dayDiv.classList.contains('bg-blue-600') 
                ? "absolute bottom-1 w-1 h-1 bg-white rounded-full" 
                : "absolute bottom-1 w-1 h-1 bg-sky-500 rounded-full";
            dayDiv.appendChild(dotPenanda);
        }
        
        calendarDaysContainer.appendChild(dayDiv);
    }
}

function changeMonth(direction) {
    currentMonth += direction;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    } else if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar();
}

// Jalankan fungsi kalender saat halaman selesai dimuat sepenuhnya
document.addEventListener('DOMContentLoaded', function() {
    renderCalendar();
});

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

        const matchesSearch = namaKegiatan.includes(searchInput);
        const matchesFilter = filterSelect === "" || tipeKegiatan === filterSelect;

        if (matchesSearch && matchesFilter) {
            row.classList.remove('hidden');
            visibleCount++;
        } else {
            row.classList.add('hidden');
        }
    });

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
    
    const trixEditor = document.querySelector("trix-editor");
    if (trixEditor) {
        trixEditor.editor.loadHTML('');
    }

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
        
        const trixEditor = document.querySelector("trix-editor");
        if (trixEditor) {
            trixEditor.editor.loadHTML(data.deskripsi || '');
        } else {
            document.getElementById('kegiatan_deskripsi').value = data.deskripsi || '';
        }

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