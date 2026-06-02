@extends('layouts.user')

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
            @empty  {{-- <-- SUDAH DIPERBAIKI --}}
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
                        <td class="px-4 py-3 max-w-[280px]">
                            <div class="font-semibold text-gray-900 name-target">{{ $event->kegiatan }}</div>
                            <div class="text-[0.72rem] text-gray-500 line-clamp-2 mt-0.5">
                                {{ strip_tags($event->deskripsi ?? '-') }}
                            </div>
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
                            <button type="button" onclick='openEventModal(@json($event))' class="btn btn-ghost btn-icon btn-sm text-blue-600 font-semibold hover:underline">Selengkapnya</button>
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

{{-- MODAL DETAIL EVENT --}}
<div
    id="eventModal"
    class="fixed inset-0 bg-black/60 z-[9999] hidden items-center justify-center p-4">

    <div class="bg-white rounded-3xl w-full max-w-3xl max-h-[90vh] overflow-y-auto shadow-2xl flex flex-col">

        <div
            id="eventModalBanner"
            class="h-48 bg-gradient-to-r from-[#0d1a6e] to-[#1e38cc] flex items-center justify-center text-7xl text-white shrink-0">
            📅
        </div>

        <div class="p-5 md:p-8">

            <div class="flex justify-between items-start mb-5 gap-3">

                <div>
                    <div
                        id="modalType"
                        class="inline-block px-3 py-1 rounded-full bg-blue-100 text-blue-700 text-xs font-bold uppercase mb-3">
                    </div>

                    <h2
                        id="modalTitle"
                        class="text-2xl md:text-3xl font-extrabold text-[#0d0f1a] break-words">
                    </h2>
                </div>

                <button
                    onclick="closeEventModal()"
                    class="w-10 h-10 rounded-full bg-gray-100 hover:bg-red-100 transition text-gray-600 shrink-0">
                    ✕
                </button>

            </div>

            <div class="grid grid-cols-2 gap-3 md:gap-5 mb-6">

                <div class="bg-gray-50 rounded-xl p-3 md:p-4">
                    <div class="text-xs text-gray-500 mb-1">Tanggal</div>
                    <div id="modalTanggal" class="font-bold text-sm md:text-base text-gray-800"></div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 md:p-4">
                    <div class="text-xs text-gray-500 mb-1">Waktu</div>
                    <div id="modalWaktu" class="font-bold text-sm md:text-base text-gray-800"></div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 md:p-4 col-span-2 sm:col-span-1">
                    <div class="text-xs text-gray-500 mb-1">Tempat</div>
                    <div id="modalTempat" class="font-bold text-sm md:text-base text-gray-800 break-words"></div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 md:p-4">
                    <div class="text-xs text-gray-500 mb-1">PIC</div>
                    <div id="modalPic" class="font-bold text-sm md:text-base text-gray-800"></div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 md:p-4">
                    <div class="text-xs text-gray-500 mb-1">Kuota</div>
                    <div id="modalKuota" class="font-bold text-sm md:text-base text-gray-800"></div>
                </div>

                <div class="bg-gray-50 rounded-xl p-3 md:p-4">
                    <div class="text-xs text-gray-500 mb-1">Status</div>
                    <div id="modalStatus" class="font-bold text-sm md:text-base text-gray-800"></div>
                </div>

            </div>

            <div>
                <h3 class="font-bold text-lg mb-2 text-gray-900">
                    Deskripsi Kegiatan
                </h3>

                <div
                    id="modalDeskripsi"
                    class="text-gray-600 text-sm md:text-base leading-relaxed max-h-[220px] overflow-y-auto pr-2">
                </div>
            </div>

        </div>

    </div>

</div>
@endsection

@push('styles')
<style>
/* Style pembantu agar modal berfungsi saat display:flex disematkan */
.modal-overlay.open { display: flex !important; }

/* Custom stylesheet render tag HTML di dalam lingkup deskripsi modal */
#modalDeskripsi ul { list-style-type: disc !important; padding-left: 1.25rem !important; margin-bottom: 0.5rem; }
#modalDeskripsi ol { list-style-type: decimal !important; padding-left: 1.25rem !important; margin-bottom: 0.5rem; }
#modalDeskripsi a { color: #1a2fb5 !important; text-decoration: underline !important; font-weight: 600; }
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

/**
 * FUNGSI UNTUK MODAL DETAIL INFO ("Selengkapnya")
 */
function openEventModal(event)
{
    const emojiMap = {
        webinar: "🎤",
        workshop: "📚",
        kompetisi: "🏆",
        company_visit: "🏛️",
        seminar: "🎓",
        rapat: "💼"
    };

    document.getElementById('eventModalBanner').innerHTML = emojiMap[event.tipe] || '📅';
    document.getElementById('modalType').innerText = (event.tipe ?? '-').replace('_',' ');
    document.getElementById('modalTitle').innerText = event.kegiatan ?? '-';
    document.getElementById('modalTanggal').innerText = event.tanggal ?? '-';
    
    document.getElementById('modalWaktu').innerText = 
        (event.waktu_mulai ?? '-') + (event.waktu_selesai ? ' - ' + event.waktu_selesai : '');

    document.getElementById('modalTempat').innerText = event.tempat ?? '-';
    document.getElementById('modalPic').innerText = event.pic ?? '-';
    document.getElementById('modalKuota').innerText = event.kuota ?? 'Tidak dibatasi';
    document.getElementById('modalStatus').innerText = event.status ?? '-';
    
    // MODIFIKASI UTAMA: Menggunakan innerHTML agar style HTML tereksekusi dengan benar di modal detail info
    document.getElementById('modalDeskripsi').innerHTML = event.deskripsi ?? '<p class="text-gray-400">Tidak ada deskripsi.</p>';

    // Menampilkan modal
    document.getElementById('eventModal').classList.remove('hidden');
    document.getElementById('eventModal').classList.add('flex');
}

function closeEventModal()
{
    document.getElementById('eventModal').classList.add('hidden');
    document.getElementById('eventModal').classList.remove('flex');
}
</script>
@endpush