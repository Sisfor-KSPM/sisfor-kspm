{{-- resources/views/welcome.blade.php --}}
@extends('layouts.app')

@section('title', 'KSPM SV IPB — Home')

@section('styles')
.hero::before{content:'';position:absolute;top:-100px;right:-100px;width:500px;height:500px;border-radius:50%;background:radial-gradient(circle,rgba(26,47,181,0.06) 0%,transparent 70%);pointer-events:none}
.hero::after{content:'';position:absolute;inset:0;background:radial-gradient(ellipse at 70% 40%,rgba(26,47,181,0.04) 0%,transparent 60%);pointer-events:none}
@endsection

@section('content')

{{-- ========== HERO ========== --}}
<section class="hero relative overflow-hidden flex items-center bg-white"
         style="padding-top:40px; min-height:calc(100vh - 110px)">
  <div class="max-w-[1200px] mx-auto px-10 py-[60px] w-full grid grid-cols-1 md:grid-cols-2 gap-20 items-center">

    {{-- Teks Kiri --}}
    <div>
      <h1 data-aos="fade-up" data-aos-delay="100"
          class="text-[clamp(2.4rem,4vw,3.8rem)] leading-[1.1] text-[#0d0f1a] mb-[18px] font-medium tracking-[-0.02em]">
          Kelompok Studi<br>Pasar Modal SV IPB
      </h1>

      <p data-aos="fade-up" data-aos-delay="200"
         class="text-base text-[#5a6080] leading-[1.8] max-w-[480px] mb-8">
          Explore in-depth market analysis, curated watchlist, and comprehensive
          market research with our dedicated team. Stay informed about the dynamic
          world of capital markets.
      </p>

      <div data-aos="fade-up" data-aos-delay="300" class="flex gap-3 flex-wrap">
        <a href="{{ url('/events') }}"
           class="px-[30px] py-[13px] rounded-lg font-bold text-[0.9rem] bg-[#1a2fb5] text-white no-underline
                  transition-all hover:bg-[#1e38cc] hover:-translate-y-0.5
                  hover:shadow-[0_8px_20px_rgba(26,47,181,0.3)]">
          Events →
        </a>
        <a href="{{ url('/elibrary') }}"
           class="px-[30px] py-[13px] rounded-lg font-semibold text-[0.9rem]
                  border-[1.5px] border-[#d0d5e8] text-[#1c1f3a] no-underline
                  transition-all hover:border-[#1a2fb5] hover:text-[#1a2fb5]">
          Research →
        </a>
      </div>
    </div>

    {{-- Gambar Kanan --}}
    @if($header && $header->main_image)
      <img src="{{ asset('storage/' . $header->main_image) }}"
           alt="Hero Image"
           class="w-full max-w-[500px] h-auto block mx-auto object-contain"
           data-aos="fade-left" data-aos-delay="200">
    @else
      <img src="{{ asset('home-asset/logo_kspm.png') }}"
           alt="logo KSPM"
           class="w-full max-w-[500px] h-auto block mx-auto object-contain"
           data-aos="fade-left" data-aos-delay="200">
    @endif

  </div>
</section>

{{-- ========== ABOUT SNIPPET ========== --}}
<section class="bg-[#f7f8fc] py-24">
  <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 md:grid-cols-2 gap-20 items-center">

    <div data-aos="fade-right" class="rounded-3xl overflow-hidden relative min-h-[420px]">
      <img src="https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?ixlib=rb-1.2.1&auto=format&fit=crop&w=1470&q=80"
           alt="Stock Market"
           class="w-full h-[420px] object-cover block rounded-3xl">
      
    </div>

    <div>
      <div data-aos="fade-up"
          class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5">
          {{ $home->tagline }}
      </div>

      <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] tracking-[-0.02em] font-medium">
          {!! nl2br(e($home->judul)) !!}
      </h2>

      <p class="text-[0.95rem] text-[#5a6080] leading-[1.8] max-w-[540px] mt-3">
          {{ $home->deskripsi }}
      </p>
      <div class="mt-6">
        <a href="{{ url('/about') }}"
           class="px-[30px] py-[13px] rounded-lg font-bold text-[0.9rem] bg-[#1a2fb5] text-white no-underline inline-block transition-all hover:bg-[#1e38cc]">
          Our Journey →
        </a>
      </div>
    </div>

  </div>
</section>

{{-- ========== KEY BENEFITS ========== --}}
<section class="bg-white py-24">
  <div class="max-w-[1200px] mx-auto px-10">

    <div class="text-center mb-12">
      <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5 inline-block">
        Key Benefits
      </div>
      <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] tracking-[-0.02em] font-medium">
        Kelompok Studi Pasar Modal<br>Sekolah Vokasi IPB University
      </h2>
    </div>

    @php
      $benefits = [
        ['icon' => 'network.png',  'title' => 'Network',     'desc' => 'Connect with professionals, expand your contacts, and foster valuable relationships.'],
        ['icon' => 'env.png',      'title' => 'Empowerment', 'desc' => 'Gain confidence and support to take control of your journey.'],
        ['icon' => 'dev.png',      'title' => 'Development', 'desc' => 'Access resources for continuous skill growth and stay ahead in your field.'],
        ['icon' => 'com.png',      'title' => 'Community',   'desc' => 'Be part of a thriving community of like-minded investors and learners.'],
        ['icon' => 'opp.png',      'title' => 'Opportunity', 'desc' => 'Seize exclusive chances for personal and professional advancement.'],
      ];
    @endphp

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
      @foreach($benefits as $i => $b)
        <div data-aos="fade-up" data-aos-delay="{{ $i * 50 }}"
             class="bg-[#f7f8fc] border border-[#d0d5e8] rounded-[18px] p-7 transition-all
                    hover:border-[#1a2fb5] hover:bg-[#e8ecfb] hover:-translate-y-[3px]">
          <div class="text-[2rem] mb-3.5">
            <img src="{{ asset('home-asset/' . $b['icon']) }}" alt="{{ $b['title'] }}" class="h-16">
          </div>
          <div class="text-[0.95rem] font-bold text-[#0d0f1a] mb-2">{{ $b['title'] }}</div>
          <div class="text-[0.82rem] text-[#5a6080] leading-[1.65]">{{ $b['desc'] }}</div>
        </div>
      @endforeach
    </div>

  </div>
</section>

{{-- ========== FEATURES ========== --}}
<section class="bg-[#f7f8fc] py-24">
  <div class="max-w-[1200px] mx-auto px-10">

    <div class="text-center mb-12">
      <div class="text-[0.72rem] font-bold tracking-[0.1em] uppercase text-[#1a2fb5] mb-2.5 inline-block">
        Fitur Platform
      </div>
      <h2 class="text-[clamp(1.9rem,3vw,2.6rem)] text-[#0d0f1a] leading-[1.15] tracking-[-0.02em] font-medium">
        Semua yang Kamu Butuhkan<br>dalam Satu Platform
      </h2>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">

      <div data-aos="fade-up"
           class="bg-white border border-[#d0d5e8] rounded-2xl p-[26px] transition-all cursor-pointer
                  hover:-translate-y-[3px] hover:border-[#1a2fb5] hover:shadow-[0_14px_36px_rgba(26,47,181,0.08)]"
           onclick="requireLogin('Kalkulator Saham')">
        <div class="w-[46px] h-[46px] rounded-[11px] bg-[#e8ecfb] flex items-center justify-center mb-4 overflow-hidden">
          <img src="{{ asset('home-asset/math.png') }}" alt="Kalkulator">
        </div>
        <h3 class="text-base font-extrabold text-[#0d0f1a] mb-2">Kalkulator Saham</h3>
        <p class="text-[0.82rem] text-[#5a6080] leading-[1.7]">
          Hitung profit/loss, HPP, dan simulasi portofolio dengan kalkulator saham interaktif.
        </p>
      </div>

      <div data-aos="fade-up"
           class="bg-white border border-[#d0d5e8] rounded-2xl p-[26px] transition-all cursor-pointer
                  hover:-translate-y-[3px] hover:border-[#1a2fb5] hover:shadow-[0_14px_36px_rgba(26,47,181,0.08)]"
           onclick="requireLogin('Simulasi Investasi')">
        <div class="w-[46px] h-[46px] rounded-[11px] bg-[#e8ecfb] flex items-center justify-center mb-4 overflow-hidden">
          <img src="{{ asset('home-asset/invv.png') }}" alt="Simulasi">
        </div>
        <h3 class="text-base font-extrabold text-[#0d0f1a] mb-2">Simulasi Investasi</h3>
        <p class="text-[0.82rem] text-[#5a6080] leading-[1.7]">
          Latih kemampuan investasimu dengan simulasi pasar saham real-time tanpa risiko.
        </p>
      </div>

      <div data-aos="fade-up" data-aos-delay="80"
           class="bg-white border border-[#d0d5e8] rounded-2xl p-[26px] transition-all cursor-pointer
                  hover:-translate-y-[3px] hover:border-[#1a2fb5] hover:shadow-[0_14px_36px_rgba(26,47,181,0.08)]"
           onclick="window.location.href='{{ url('/kamus') }}'">
        <div class="w-[46px] h-[46px] rounded-[11px] bg-[#e8ecfb] flex items-center justify-center mb-4 overflow-hidden">
          <img src="{{ asset('home-asset/kms.png') }}" alt="Kamus">
        </div>
        <h3 class="text-base font-extrabold text-[#0d0f1a] mb-2">Kamus Pasar Modal</h3>
        <p class="text-[0.82rem] text-[#5a6080] leading-[1.7]">
          Ratusan istilah pasar modal A–Z lengkap dengan definisi yang mudah dipahami.
        </p>
      </div>

      <div data-aos="fade-up" data-aos-delay="160"
           class="bg-white border border-[#d0d5e8] rounded-2xl p-[26px] transition-all cursor-pointer
                  hover:-translate-y-[3px] hover:border-[#1a2fb5] hover:shadow-[0_14px_36px_rgba(26,47,181,0.08)]"
           onclick="window.location.href='{{ url('/elibrary') }}'">
        <div class="w-[46px] h-[46px] rounded-[11px] bg-[#e8ecfb] flex items-center justify-center mb-4 overflow-hidden">
          <img src="{{ asset('home-asset/lb.png') }}" alt="E-Library">
        </div>
        <h3 class="text-base font-extrabold text-[#0d0f1a] mb-2">E-Library Riset</h3>
        <p class="text-[0.82rem] text-[#5a6080] leading-[1.7]">
          Download laporan riset emiten dan market outlook dari tim analis KSPM.
        </p>
      </div>

    </div>
  </div>
</section>

{{-- ========== CONTACT HOME ========== --}}
<section class="bg-white py-24">
  <div class="max-w-[1200px] mx-auto px-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-start">

    {{-- Info Kontak --}}
    <div>
      <div class="text-[0.82rem] font-bold text-[#1a2fb5] mb-2">Your Insights Matter</div>
      <h2 class="text-[clamp(1.8rem,2.5vw,2.4rem)] font-medium mb-3 text-[#0d0f1a] leading-[1.2]">
        Send Us a Message
      </h2>
      <p class="text-[0.9rem] text-[#5a6080] leading-[1.75] mb-6">
        Your feedbacks are important to us. Reach out and our team will ensure you receive
        the support you're looking for.
      </p>

      @php
        $contacts = [
          ['icon' => 'email.png', 'alt' => 'email', 'text' => 'kspmsvipb@apps.ipb.ac.id'],
          ['icon' => 'hp.png',    'alt' => 'hp',    'text' => '+62 812-3456-7890 (Public Relation)'],
          ['icon' => 'loc.png',   'alt' => 'lokasi','text' => 'Kampus SV IPB University, Bogor'],
        ];
      @endphp

      <div class="flex flex-col gap-[18px]">
        @foreach($contacts as $c)
          <div class="flex items-center gap-3">
            <div class="w-9 h-9 bg-[#e8ecfb] rounded-[10px] flex items-center justify-center flex-shrink-0">
              <img src="{{ asset('home-asset/' . $c['icon']) }}" alt="{{ $c['alt'] }}">
            </div>
            <div class="text-[0.875rem] text-[#1c1f3a] font-medium">{{ $c['text'] }}</div>
          </div>
        @endforeach
        <div class="flex items-center gap-3">
          <div class="w-9 h-9 bg-[#e8ecfb] rounded-[10px] flex items-center justify-center flex-shrink-0">
            <img src="{{ asset('home-asset/link.png') }}" alt="link">
          </div>
          <div class="text-[0.875rem] text-[#1c1f3a] font-medium">
            <a href="https://linktr.ee/KSPM_SVIPB" target="_blank" class="text-[#1a2fb5]">
              linktr.ee/KSPM_SVIPB
            </a>
          </div>
        </div>
      </div>
    </div>

    {{-- Form Kontak --}}
    <div class="bg-white border border-[#d0d5e8] rounded-[18px] p-8">
      <div class="text-[1.1rem] font-bold text-[#0d0f1a] mb-1">Send Us a Message</div>
      <div class="text-[0.83rem] text-[#5a6080] mb-5">
        Fill in the form below and our team will get back to you shortly.
      </div>

      <div class="mb-3">
        <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Full Name *</label>
        <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
               type="text" placeholder="Enter your full name">
      </div>

      <div class="grid grid-cols-2 gap-2.5">
        <div class="mb-3">
          <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Email *</label>
          <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                 type="email" placeholder="email@domain.com">
        </div>
        <div class="mb-3">
          <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Phone</label>
          <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
                 type="text" placeholder="+62...">
        </div>
      </div>

      <div class="mb-3">
        <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Subject *</label>
        <input class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none focus:border-[#1a2fb5] focus:bg-white"
               type="text" placeholder="Message subject">
      </div>

      <div class="mb-3">
        <label class="text-[0.75rem] font-semibold text-[#5a6080] mb-1 block">Message *</label>
        <textarea class="w-full px-3 py-2.5 border-[1.5px] border-[#d0d5e8] rounded-lg text-[0.875rem] bg-[#f7f8fc] outline-none min-h-[110px] resize-y focus:border-[#1a2fb5] focus:bg-white"
                  placeholder="Write your message here..."></textarea>
      </div>

      <button class="w-full py-3 rounded-[9px] font-bold text-[0.875rem] bg-[#1a2fb5] text-white border-none cursor-pointer transition-all hover:bg-[#1e38cc]"
              onclick="showToast('✅ Message sent! We will get back to you shortly.')">
        Send Message
      </button>
    </div>

  </div>
</section>

@endsection