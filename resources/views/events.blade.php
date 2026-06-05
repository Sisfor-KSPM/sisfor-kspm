{{-- resources/views/events.blade.php --}}
@extends('layouts.app')

@section('title', 'KSPM SV IPB — Events')

@section('styles')
<style>
/* Event Hero Slider */
#eph-track{
    display:flex;
    width:100%;
}
.eph-slide{
    position:relative;
    min-height:420px;
    display:flex;
    align-items:center;
    background: linear-gradient(135deg,#0d1a6e,#1e38cc);
    width: 100%;
    flex-shrink: 0;
}
.eph-slide-img{
    position:absolute;
    inset:0;
    width:100%;
    height:100%;
    object-fit:cover;
    z-index:0
}
.eph-slide-placeholder{
    position:absolute;
    inset:0;
    background:linear-gradient(135deg,#0d1a6e,#1e38cc);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:5rem;
    z-index:0
}
.eph-slide-overlay{
    position:absolute;
    inset:0;
    background:linear-gradient(
        to right,
        rgba(10,15,50,0.85) 40%,
        rgba(10,15,50,0.3)
    );
    z-index:1
}
.eph-slide-tag{
    display:inline-block;
    background:rgba(255,255,255,0.12);
    border:1px solid rgba(255,255,255,0.2);
    color:rgba(255,255,255,0.85);
    padding:4px 12px;
    border-radius:20px;
    font-size:0.72rem;
    font-weight:700;
    margin-bottom:10px
}
.eph-slide-sub{
    font-size:0.88rem;
    color:rgba(255,255,255,0.65);
    line-height:1.7;
    max-width:500px
}
.eph-dot{
    width:6px;
    height:6px;
    background:rgba(255,255,255,0.35);
    border-radius:3px;
    cursor:pointer;
    transition:all 0.3s
}
.eph-dot.active{
    width:18px!important;
    background:#fff!important
}

/* Grid */
.events-grid{
    display:grid;
    grid-template-columns:repeat(auto-fill,minmax(320px,1fr));
    gap:20px
}

/* Cards */
.event-card{
    display:flex;
    flex-direction:column;
    background:#fff;
    border:1px solid #d0d5e8;
    border-radius:18px;
    overflow:hidden;
    transition:all .25s ease
}
.event-card .p-5{
    display:flex;
    flex-direction:column;
    flex:1;
}
.event-card button{
    margin-top:auto;
}
.event-card:hover{
    transform:translateY(-4px);
    border-color:#1a2fb5;
    box-shadow:0 14px 36px rgba(26,47,181,0.12)
}
.event-cover{
    height:160px;
    background:linear-gradient(135deg,#0d1a6e,#1e38cc);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:3.5rem
}

.ev-filter-btn.active{
    background:#1a2fb5!important;
    color:#fff!important;
    border-color:#1a2fb5!important
}

/* Styling konten HTML di dalam modal */
#modalDeskripsi ul { list-style-type: disc !important; padding-left: 1.25rem !important; margin-bottom: 0.5rem; }
#modalDeskripsi ol { list-style-type: decimal !important; padding-left: 1.25rem !important; margin-bottom: 0.5rem; }
#modalDeskripsi a { color: #1a2fb5 !important; text-decoration: underline !important; font-weight: 600; }
</style>
@endsection

@section('content')

{{-- HERO --}}
<div class="relative overflow-hidden mt-[68px]">

    @php
        $heroSlides = $events->take(3)->map(function($event) {
            $emojiMap = [
                'webinar' => '🎤',
                'workshop' => '📚',
                'kompetisi' => '🏆',
                'company_visit' => '🏛️',
                'seminar' => '🎓',
                'default' => '📅'
            ];
            $emoji = $emojiMap[$event->tipe] ?? '📅';
            return [
                'emoji' => $emoji,
                'title' => $event->kegiatan,
                // strip_tags digunakan agar tag HTML bersih dari slider hero
                'subtitle' => strip_tags($event->deskripsi ?? 'Event KSPM'),
                'date' => \Carbon\Carbon::parse($event->tanggal)->format('F Y')
            ];
        })->values()->toArray(); // Penambahan ->values() agar index selalu 0, 1, 2
    @endphp

    <div id="eph-track" class="flex transition-transform duration-500 ease-in-out w-full">
        @if(count($heroSlides) > 0)
            @foreach ($heroSlides as $index => $slide)
                <div class="eph-slide {{ $index === 0 ? 'active' : '' }}">
                    
                    <div class="eph-slide-placeholder">
                        {{ $slide['emoji'] }}
                    </div>

                    <div class="eph-slide-overlay"></div>
                    <div class="relative z-[2] px-6 md:px-10 py-14 md:py-20 max-w-[700px]">
                        <div class="max-w-[1200px] mx-auto px-6 lg:px-10 py-20">
                            {{-- Isi konten (tag, h1, p) --}}
                            <div class="eph-slide-tag">📅 {{ $slide['date'] }}</div>
                            <h1 class="text-[clamp(1.8rem,3.8vw,3rem)] text-white font-extrabold leading-[1.15] mb-4">
                                {{ $slide['title'] }}
                            </h1>
                            <p class="eph-slide-sub line-clamp-2">{{ $slide['subtitle'] }}</p>
                        </div>    
                    </div>
                </div>
            @endforeach
        @else
            <div class="eph-slide w-full shrink-0">
                <div class="eph-slide-placeholder">📅</div>
                <div class="eph-slide-overlay"></div>
                <div class="relative z-[2] px-10 py-20 max-w-[700px]">
                    <h1 class="text-[clamp(1.8rem,3.8vw,3rem)] text-white font-extrabold leading-[1.15] mb-4">
                        Belum ada event terbaru
                    </h1>
                </div>
            </div>
        @endif
    </div>

    {{-- NAV --}}
    <button
        class="absolute top-1/2 -translate-y-1/2 left-5 w-10 h-10 rounded-full bg-white/10 border border-white/25 text-white z-10 hover:bg-white/20"
        onclick="ephNav(-1)">
        ‹
    </button>

    <button
        class="absolute top-1/2 -translate-y-1/2 right-5 w-10 h-10 rounded-full bg-white/10 border border-white/25 text-white z-10 hover:bg-white/20"
        onclick="ephNav(1)">
        ›
    </button>

    <div
        class="absolute bottom-5 left-10 flex gap-2 z-10"
        id="eph-dots">
    </div>

</div>

{{-- EVENTS --}}
<section class="bg-[#f7f8fc] py-14 md:py-20">

    <div class="max-w-[1200px] mx-auto px-10">

        <div class="flex justify-between items-end flex-wrap gap-4 mb-10">

            <div>
                <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2">
                    Semua Kegiatan
                </div>

                <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] font-medium text-[#0d0f1a] leading-[1.15]">
                    Event KSPM SV IPB
                </h2>
            </div>

            <div class="flex flex-wrap justify-start lg:justify-end gap-2">

                <button
                    class="ev-filter-btn active px-5 py-2 rounded-lg text-[0.82rem] font-semibold border border-[#1a2fb5]"
                    onclick="filterEvents('all', this)">
                    Semua
                </button>

                <button
                    class="ev-filter-btn px-5 py-2 rounded-lg text-[0.82rem] font-semibold border border-[#d0d5e8] bg-white"
                    onclick="filterEvents('webinar', this)">
                    Webinar
                </button>

                <button
                    class="ev-filter-btn px-5 py-2 rounded-lg text-[0.82rem] font-semibold border border-[#d0d5e8] bg-white"
                    onclick="filterEvents('workshop', this)">
                    Workshop
                </button>

                <button
                    class="ev-filter-btn px-5 py-2 rounded-lg text-[0.82rem] font-semibold border border-[#d0d5e8] bg-white"
                    onclick="filterEvents('kompetisi', this)">
                    Kompetisi
                </button>

            </div>

        </div>

        @php
            $emojiMap = [
                'webinar' => '🎤',
                'workshop' => '📚',
                'kompetisi' => '🏆',
                'company_visit' => '🏛️',
                'seminar' => '🎓',
                'default' => '📅'
            ];
        @endphp

        <div class="events-grid" id="events-grid">

            @forelse ($events as $event)
                <div
                    class="event-card"
                    data-category="{{ $event->tipe }}">

                    <div class="event-cover">
                        {{ $emojiMap[$event->tipe] ?? '📅' }}
                    </div>

                    <div class="p-5">

                        <div class="text-[0.68rem] font-bold uppercase tracking-[0.06em] text-[#1a2fb5] mb-2">
                            {{ ucfirst($event->tipe) }}
                        </div>

                        <div class="text-[1rem] font-extrabold text-[#0d0f1a] mb-1">
                            {{ $event->kegiatan }}
                        </div>

                        <div class="text-[0.75rem] text-[#5a6080] mb-3">
                            📅 {{ \Carbon\Carbon::parse($event->tanggal)->format('d F Y') }}
                        </div>

                        <p class="text-[0.83rem] text-[#5a6080] leading-[1.7] mb-5 line-clamp-2">
                            {{ strip_tags($event->deskripsi ?? 'Event KSPM') }}
                        </p>

                        <button
                            onclick='openEventModal(@json($event))'
                            class="w-full py-2.5 rounded-lg bg-[#e8ecfb] text-[#1a2fb5] font-bold text-[0.82rem] hover:bg-[#1a2fb5] hover:text-white transition-all">
                            Lihat Detail →
                        </button>

                    </div>

                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-4xl mb-3">📅</div>
                    <p class="text-gray-500">Belum ada event tersedia</p>
                </div>
            @endforelse

        </div>

    </div>

</section>


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
                    type="button"
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

@section('scripts')
<script>
    /* HERO SLIDER (UPDATED) */
    let ephIdx = 0;
    let ephTimer; // Penambahan timer

    const ephSlides = document.querySelectorAll('.eph-slide');
    const ephDots = document.getElementById('eph-dots');
    const ephTrack = document.getElementById('eph-track'); // Mengambil track

    function renderDots() {
        ephDots.innerHTML = '';
        ephSlides.forEach((_, i) => {
            const dot = document.createElement('button');
            dot.className = 'eph-dot' + (i === 0 ? ' active' : '');
            dot.onclick = () => goEph(i);
            ephDots.appendChild(dot);
        });
    }

    function goEph(index) {
        if(ephSlides.length === 0) return;
        
        // Nonaktifkan dot saat ini
        ephDots.children[ephIdx].classList.remove('active');

        // Perbarui Index
        ephIdx = index;

        // Aktifkan dot baru
        ephDots.children[ephIdx].classList.add('active');

        // Geser track
        ephTrack.style.transform = `translateX(-${ephIdx * 100}%)`;

        resetTimer(); // Mereset interval jika digeser manual
    }

    function ephNav(dir) {
        if(ephSlides.length === 0) return;
        goEph(
            (ephIdx + dir + ephSlides.length) % ephSlides.length
        );
    }

    function resetTimer() {
        clearInterval(ephTimer);
        ephTimer = setInterval(() => {
            ephNav(1);
        }, 5000);
    }

    if(ephSlides.length > 0) {
        renderDots();
        resetTimer();
    }


    /* FILTER EVENTS */
    function filterEvents(category, btn) {
        document.querySelectorAll('.ev-filter-btn')
            .forEach(el => el.classList.remove('active'));

        btn.classList.add('active');

        const cards = document.querySelectorAll('#events-grid .event-card');

        cards.forEach(card => {
            if (
                category === 'all' ||
                card.dataset.category === category
            ) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    /* MODAL HANDLER */
    function openEventModal(event)
    {
        if (window.AnalyticsTracker && event?.id) {
            AnalyticsTracker.trackModal('event_detail', event.id);
        }

        const emojiMap = {
            webinar: "🎤",
            workshop: "📚",
            kompetisi: "🏆",
            company_visit: "🏛️",
            seminar: "🎓"
        };

        document.getElementById('eventModalBanner').innerHTML =
            emojiMap[event.tipe] || '📅';

        document.getElementById('modalType').innerText =
            event.tipe ? event.tipe.replace('_',' ') : '-';

        document.getElementById('modalTitle').innerText =
            event.kegiatan ?? '-';

        document.getElementById('modalTanggal').innerText =
            event.tanggal ?? '-';

        document.getElementById('modalWaktu').innerText =
            (event.waktu_mulai ?? '-') +
            ' - ' +
            (event.waktu_selesai ?? '-');

        document.getElementById('modalTempat').innerText =
            event.tempat ?? '-';

        document.getElementById('modalPic').innerText =
            event.pic ?? '-';

        document.getElementById('modalKuota').innerText =
            event.kuota ?? 'Tidak dibatasi';

        document.getElementById('modalStatus').innerText =
            event.status ?? '-';

        document.getElementById('modalDeskripsi').innerHTML =
            event.deskripsi ?? '<p class="text-gray-400">Tidak ada deskripsi.</p>';

        document.getElementById('eventModal')
            .classList.remove('hidden');

        document.getElementById('eventModal')
            .classList.add('flex');
    }

    function closeEventModal()
    {
        document.getElementById('eventModal')
            .classList.add('hidden');

        document.getElementById('eventModal')
            .classList.remove('flex');
    }
</script>
@endsection