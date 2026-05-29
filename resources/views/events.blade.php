{{-- resources/views/events.blade.php --}}
@extends('layouts.app')

@section('title', 'KSPM SV IPB — Events')

@section('styles')

/* Event Hero Slider */
.eph-slide{
    display:none;
    position:relative;
    min-height:420px;
    align-items:center
}
.eph-slide.active{
    display:flex
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
    background:#fff;
    border:1px solid #d0d5e8;
    border-radius:18px;
    overflow:hidden;
    transition:all .25s ease
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

@endsection

@section('content')

{{-- HERO --}}
<div class="relative overflow-hidden mt-[68px]" id="eph-track">

    @php
        $heroSlides = [
            [
                'emoji' => '🎤',
                'title' => 'Investalk Vol. 5 — Saham Dividen',
                'subtitle' => 'Diskusi bersama praktisi pasar modal.',
                'date' => 'Maret 2025'
            ],
            [
                'emoji' => '📚',
                'title' => 'Sekolah Pasar Modal Batch 12',
                'subtitle' => 'Belajar investasi dari dasar hingga analisis.',
                'date' => 'Februari 2025'
            ],
            [
                'emoji' => '🏛️',
                'title' => 'Company Visit — BEI Jakarta',
                'subtitle' => 'Kunjungan langsung ke Bursa Efek Indonesia.',
                'date' => 'Januari 2025'
            ],
        ];
    @endphp

    @foreach ($heroSlides as $index => $slide)
        <div class="eph-slide {{ $index === 0 ? 'active' : '' }}">
            
            <div class="eph-slide-placeholder">
                {{ $slide['emoji'] }}
            </div>

            <div class="eph-slide-overlay"></div>

            <div class="relative z-[2] px-10 py-20 max-w-[700px]">
                
                <div class="eph-slide-tag">
                    📅 {{ $slide['date'] }}
                </div>

                <h1 class="text-[clamp(1.8rem,3.8vw,3rem)] text-white font-extrabold leading-[1.15] mb-4">
                    {{ $slide['title'] }}
                </h1>

                <p class="eph-slide-sub">
                    {{ $slide['subtitle'] }}
                </p>

            </div>
        </div>
    @endforeach

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
<section class="bg-[#f7f8fc] py-20">

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

            <div class="flex flex-wrap gap-2">

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
            $events = [
                [
                    'title' => 'Investalk Vol. 5',
                    'type' => 'webinar',
                    'tag' => 'Webinar',
                    'date' => '22 Maret 2025',
                    'emoji' => '🎤',
                    'desc' => 'Diskusi mendalam tentang strategi investasi saham dividen.'
                ],
                [
                    'title' => 'Sekolah Pasar Modal',
                    'type' => 'workshop',
                    'tag' => 'Workshop',
                    'date' => '10 Februari 2025',
                    'emoji' => '📚',
                    'desc' => 'Program edukasi intensif pasar modal.'
                ],
                [
                    'title' => 'Company Visit BEI',
                    'type' => 'workshop',
                    'tag' => 'Company Visit',
                    'date' => '15 Januari 2025',
                    'emoji' => '🏛️',
                    'desc' => 'Kunjungan ke Bursa Efek Indonesia.'
                ],
                [
                    'title' => 'Stock Trading Competition',
                    'type' => 'kompetisi',
                    'tag' => 'Kompetisi',
                    'date' => '20 November 2024',
                    'emoji' => '🏆',
                    'desc' => 'Kompetisi trading saham antar mahasiswa.'
                ],
            ];
        @endphp

        <div class="events-grid" id="events-grid">

            @foreach ($events as $event)
                <div
                    class="event-card"
                    data-category="{{ $event['type'] }}">

                    <div class="event-cover">
                        {{ $event['emoji'] }}
                    </div>

                    <div class="p-5">

                        <div class="text-[0.68rem] font-bold uppercase tracking-[0.06em] text-[#1a2fb5] mb-2">
                            {{ $event['tag'] }}
                        </div>

                        <div class="text-[1rem] font-extrabold text-[#0d0f1a] mb-1">
                            {{ $event['title'] }}
                        </div>

                        <div class="text-[0.75rem] text-[#5a6080] mb-3">
                            📅 {{ $event['date'] }}
                        </div>

                        <p class="text-[0.83rem] text-[#5a6080] leading-[1.7] mb-5">
                            {{ $event['desc'] }}
                        </p>

                        <button
                            class="w-full py-2.5 rounded-lg bg-[#e8ecfb] text-[#1a2fb5] font-bold text-[0.82rem] hover:bg-[#1a2fb5] hover:text-white transition-all">
                            Lihat Detail →
                        </button>

                    </div>

                </div>
            @endforeach

        </div>

    </div>

</section>

@endsection

@section('scripts')

<script>

    /* HERO SLIDER */
    let ephIdx = 0;

    const ephSlides = document.querySelectorAll('.eph-slide');
    const ephDots = document.getElementById('eph-dots');

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

        ephSlides[ephIdx].classList.remove('active');
        ephDots.children[ephIdx].classList.remove('active');

        ephIdx = index;

        ephSlides[ephIdx].classList.add('active');
        ephDots.children[ephIdx].classList.add('active');

    }

    function ephNav(dir) {

        goEph(
            (ephIdx + dir + ephSlides.length) % ephSlides.length
        );

    }

    renderDots();

    setInterval(() => {
        ephNav(1);
    }, 5000);


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

</script>

@endsection