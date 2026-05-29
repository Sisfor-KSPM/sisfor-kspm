{{-- resources/views/partials/mobile-menu.blade.php --}}
<div class="mobile-menu fixed top-[68px] left-0 right-0 bottom-0 z-[199] bg-white overflow-y-auto px-6 pb-10 pt-6 border-t border-[#d0d5e8]"
     id="mobile-menu">

  {{-- Nav Links --}}
  <div class="flex flex-col gap-1 mb-6">
    @php
      $mobileLinks = [
        ['label' => 'Home',      'route' => '/'],
        ['label' => 'About',     'route' => '/about'],
        ['label' => 'Events',    'route' => '/events'],
        ['label' => 'Gallery',   'route' => '/gallery'],
        ['label' => 'E-Library', 'route' => '/elibrary'],
        ['label' => 'Contact',   'route' => '/contact'],
      ];
      $currentPath = request()->path();
    @endphp

    @foreach($mobileLinks as $link)
      @php
        $isActive = ($link['route'] === '/')
          ? ($currentPath === '/' || $currentPath === '')
          : str_starts_with('/' . $currentPath, $link['route']);
      @endphp
      <a class="mobile-nav-link px-4 py-3 rounded-[10px] text-base font-semibold no-underline block transition-all
                 {{ $isActive ? 'text-[#1a2fb5] bg-[#e8ecfb] active' : 'text-[#1c1f3a] hover:text-[#1a2fb5] hover:bg-[#e8ecfb]' }}"
         href="{{ url($link['route']) }}"
         onclick="closeMobileMenu()">
        {{ $link['label'] }}
      </a>
    @endforeach
  </div>

  {{-- CTA & Auth --}}
  <div class="flex flex-col gap-2">
    <a class="px-4 py-3 rounded-[10px] text-base font-bold bg-[#e8ecfb] text-[#1a2fb5] no-underline block"
       href="{{ url('/recruit') }}">
      🎯 Open Recruitment 2025
    </a>
    <button class="px-5 py-3 rounded-[9px] text-sm font-semibold border-[1.5px] border-[#d0d5e8] text-[#1c1f3a] bg-white cursor-pointer w-full"
            onclick="openModal('login'); closeMobileMenu()">
      Sign In
    </button>
    <button class="px-5 py-3 rounded-[9px] text-sm font-bold bg-[#1a2fb5] text-white border-none cursor-pointer w-full"
            onclick="openModal('register'); closeMobileMenu()">
      Join Us
    </button>
  </div>

</div>
