{{-- resources/views/partials/navbar.blade.php --}}
<nav class="navbar fixed top-0 left-0 right-0 z-[200] bg-white/[.98] backdrop-blur-xl border-b border-[#d0d5e8] px-10 flex items-center justify-between h-[68px] transition-shadow duration-300" id="navbar">

  {{-- Logo --}}
  <a class="flex items-center gap-2 no-underline" href="{{ url('/') }}">
    <div class="w-[42px] h-[42px] bg-white flex items-center justify-center overflow-hidden">
      <img src="{{ asset('home-asset/logo_kspm.png') }}" alt="KSPM Logo" class="w-full h-full object-contain" style="transform:translateY(-3px)">
    </div>
    <div class="flex flex-col leading-tight">
      <div class="font-bold text-base text-[#1a2fb5]">KSPM SV IPB</div>
      <div class="text-[0.65rem] text-[#666] font-normal whitespace-nowrap">Kelompok Studi Pasar Modal</div>
    </div>
  </a>

  {{-- Desktop Nav Links --}}
  <div class="hidden md:flex items-center gap-0.5">
    @php
      $navLinks = [
        ['label' => 'Home',      'route' => '/'],
        ['label' => 'About',     'route' => '/about'],
        ['label' => 'Events',    'route' => '/events'],
        ['label' => 'Gallery',   'route' => '/gallery'],
        ['label' => 'E-Library', 'route' => '/elibrary'],
        ['label' => 'Kamus',     'route' => '/kamus'],
      ];
      $currentPath = request()->path();
    @endphp

    @foreach($navLinks as $link)
      @php
        $isActive = ($link['route'] === '/')
          ? ($currentPath === '/' || $currentPath === '')
          : str_starts_with('/' . $currentPath, $link['route']);
      @endphp
      <a class="nav-link px-3.5 py-1.5 rounded-lg text-sm font-medium no-underline transition-all
                 {{ $isActive ? 'text-[#1a2fb5] bg-[#e8ecfb] active' : 'text-[#5a6080] hover:text-[#1a2fb5] hover:bg-[#e8ecfb]' }}"
         href="{{ url($link['route']) }}"
         data-track-feature="navbar_{{ strtolower(str_replace(['-', ' '], '_', $link['label'])) }}"
         data-track-page="{{ strtolower(str_replace(['-', ' '], '_', $link['label'])) }}">
        {{ $link['label'] }}
      </a>
    @endforeach

    <a class="nav-link px-3.5 py-1.5 rounded-[9px] text-[0.82rem] font-bold text-white bg-[#1a2fb5] no-underline transition-all hover:bg-[#1e38cc]"
       href="{{ url('/contact') }}">
      Contact
    </a>
  </div>

  {{-- Desktop Auth Buttons --}}
  <div class="hidden md:flex items-center gap-2">
    <button class="px-5 py-2 rounded-[9px] text-sm font-semibold border-[1.5px] border-[#d0d5e8] text-[#1c1f3a] bg-white cursor-pointer transition-all hover:border-[#1a2fb5] hover:text-[#1a2fb5]"
            onclick="openModal('login')">
      Sign In
    </button>
    <button class="px-5 py-2 rounded-[9px] text-sm font-bold bg-[#1a2fb5] text-white border-none cursor-pointer transition-all hover:bg-[#1e38cc]"
            onclick="openModal('register')">
      Join Us
    </button>
  </div>

  {{-- Hamburger (Mobile) --}}
  <button class="hamburger md:hidden flex flex-col justify-center items-center w-10 h-10 cursor-pointer rounded-[9px] border-[1.5px] border-[#d0d5e8] bg-white gap-[5px] transition-all flex-shrink-0"
          id="hamburger-btn"
          onclick="toggleMobileMenu()">
    <span class="block w-5 h-[2px] bg-[#1c1f3a] rounded transition-transform duration-200"></span>
    <span class="block w-5 h-[2px] bg-[#1c1f3a] rounded transition-all duration-200"></span>
    <span class="block w-5 h-[2px] bg-[#1c1f3a] rounded transition-transform duration-200"></span>
  </button>

</nav>
