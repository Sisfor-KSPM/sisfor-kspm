{{-- resources/views/partials/footer.blade.php --}}
<footer class="bg-[#0d0f1a] pt-[60px] pb-7">
  <div class="max-w-[1200px] mx-auto px-10">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-[2fr_1fr_1fr_1fr] gap-10 mb-10">

      {{-- Brand --}}
      <div class="text-[0.83rem] text-white/40 leading-[1.75] mt-3 max-w-[240px]">
        <div class="flex items-center gap-3 mb-3.5">
          <img src="{{ asset('Logo_Kspm_Bg.png') }}" alt="KSPM" class="h-12 w-auto"
               onerror="this.style.display='none'">
          <div>
            <div class="font-extrabold text-[0.95rem] text-white">KSPM SV IPB</div>
            <div class="text-[0.63rem] text-white/35 mt-0.5">Kelompok Studi Pasar Modal</div>
          </div>
        </div>
        <p>Discover Kelompok Studi Pasar Modal Sekolah Vokasi IPB University's Activities: Find your Perfect Fit</p>
        {{-- Social Icons --}}
        <div class="flex gap-2 mt-[18px]">
          <a class="w-[34px] h-[34px] rounded-[9px] bg-white/[.06] border border-white/[.12] flex items-center justify-center text-white/50 no-underline hover:bg-white/[.18] hover:text-white"
             href="#" aria-label="Instagram">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <rect x="2" y="2" width="20" height="20" rx="5"/>
              <path d="M16 11.37A4 4 0 1112.63 8 4 4 0 0116 11.37z"/>
              <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"/>
            </svg>
          </a>
          <a class="w-[34px] h-[34px] rounded-[9px] bg-white/[.06] border border-white/[.12] flex items-center justify-center text-white/50 no-underline hover:bg-white/[.18] hover:text-white"
             href="#" aria-label="LinkedIn">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M16 8a6 6 0 016 6v7h-4v-7a2 2 0 00-2-2 2 2 0 00-2 2v7h-4v-7a6 6 0 016-6z"/>
              <rect x="2" y="9" width="4" height="12"/>
              <circle cx="4" cy="4" r="2"/>
            </svg>
          </a>
          <a class="w-[34px] h-[34px] rounded-[9px] bg-white/[.06] border border-white/[.12] flex items-center justify-center text-white/50 no-underline hover:bg-white/[.18] hover:text-white"
             href="#" aria-label="YouTube">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M22.54 6.42a2.78 2.78 0 00-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46A2.78 2.78 0 001.46 6.42 29 29 0 001 12a29 29 0 00.46 5.58A2.78 2.78 0 003.41 19.6C5.12 20 12 20 12 20s6.88 0 8.59-.4a2.78 2.78 0 001.95-1.95A29 29 0 0023 12a29 29 0 00-.46-5.58z"/>
              <polygon points="9.75 15.02 15.5 12 9.75 8.98 9.75 15.02"/>
            </svg>
          </a>
        </div>
      </div>

      {{-- Events --}}
      <div>
        <div class="text-[0.75rem] font-bold text-white mb-3 uppercase tracking-[0.08em]">Events</div>
        @foreach(['Investalk', 'Kursus Pasar Modal', 'ISTC', 'Company Visit'] as $item)
          <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white"
             href="{{ url('/events') }}">{{ $item }}</a>
        @endforeach
      </div>

      {{-- Research --}}
      <div>
        <div class="text-[0.75rem] font-bold text-white mb-3 uppercase tracking-[0.08em]">Research</div>
        @foreach(['Weekly Research', 'Equity Research', 'Market Outlook'] as $item)
          <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white"
             href="{{ url('/elibrary') }}">{{ $item }}</a>
        @endforeach
      </div>

      {{-- Community --}}
      <div>
        <div class="text-[0.75rem] font-bold text-white mb-3 uppercase tracking-[0.08em]">Community</div>
        <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white" href="{{ url('/contact') }}">Contact Us</a>
        <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white" href="#">Instagram</a>
        <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white" href="#">LinkedIn</a>
        <a class="block text-[0.82rem] text-white/40 mb-2 no-underline hover:text-white" href="#">YouTube</a>
      </div>

    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/[.07] pt-5 flex justify-between items-center flex-wrap gap-2 text-[0.78rem] text-white/30">
      <p>Copyright &copy; 2021 &mdash; {{ date('Y') }} |
        <a href="{{ url('/') }}" class="text-white/55 no-underline hover:text-white">kspmsvipb.com</a>
        | All rights reserved
      </p>
      <p>Galeri Investasi Resmi — Bursa Efek Indonesia</p>
    </div>

  </div>
</footer>
