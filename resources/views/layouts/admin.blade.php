<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8"/>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
<title>@yield('page-title', 'Admin Dashboard') — KSPM SV IPB</title>
<script src="https://cdn.tailwindcss.com"></script>
<script>
tailwind.config = {
  theme: {
    extend: {
      colors: {
        'blue-kspm': '#1a2fb5',
        'blue-mid': '#1e38cc',
        'blue-light': '#2d4ee0',
        'blue-pale': '#e8ecfb',
        'blue-dark': '#0d1a6e',
      },
      fontFamily: {
        'jakarta': ['"Plus Jakarta Sans"', 'sans-serif'],
        'mono': ['"JetBrains Mono"', 'monospace'],
      }
    }
  }
}
</script>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet"/>
<style>
/* Pindahkan CSS kustom kamu ke sini sesuai versi sebelumnya */
:root{
  --blue:#1a2fb5;--blue-mid:#1e38cc;--blue-light:#2d4ee0;--blue-pale:#e8ecfb;--blue-dark:#0d1a6e;
  --text:#1c1f3a;--muted:#5a6080;--border:#d0d5e8;--bg:#f0f4ff;
  --sidebar-w:260px;
}
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',sans-serif;color:var(--text);background:var(--bg);min-height:100vh;overflow-x:hidden}
.mono{font-family:'JetBrains Mono',monospace}
.sidebar{position:fixed;top:0px;left:0;bottom:0;width:var(--sidebar-w);background:linear-gradient(160deg,#1e3a8a 0%,#1d4ed8 60%,#2563eb 100%);z-index:40;display:flex;flex-direction:column;overflow:hidden;transition:transform .3s;}
.sidebar::before{content:'';position:absolute;top:-60px;right:-60px;width:200px;height:200px;background:rgba(255,255,255,.06);border-radius:50%}
.sidebar::after{content:'';position:absolute;bottom:-40px;left:-40px;width:160px;height:160px;background:rgba(255,255,255,.04);border-radius:50%}
.sb-logo{padding:20px;display:flex;align-items:center;gap:12px;border-bottom:1px solid rgba(255,255,255,.12);position:relative;z-index:1;}
.sb-logo-text{color:#fff;font-weight:700;font-size:.9rem;line-height:1.1}
.sb-logo-sub{font-size:.6rem;color:rgba(255,255,255,.5);font-weight:400}
.sb-admin-badge{margin:14px 20px;background:rgba(255,255,255,.12);border:1px solid rgba(255,255,255,.2);border-radius:10px;padding:12px 14px;display:flex;align-items:center;gap:10px;position:relative;z-index:1;}
.sb-avatar{width:34px;height:34px;border-radius:50%;background:linear-gradient(135deg,#60a5fa,#3b82f6);display:flex;align-items:center;justify-content:center;font-size:.75rem;font-weight:700;color:#fff}
.sb-admin-name{font-size:.82rem;font-weight:600;color:#fff}
.sb-admin-role{font-size:.65rem;color:rgba(255,255,255,.5)}
.nav-item{display:flex;align-items:center;gap:10px;padding:10px 20px;border-radius:10px;margin:2px 12px;color:rgba(255,255,255,.65);text-decoration:none;font-size:.85rem;font-weight:500;transition:all .2s;position:relative;z-index:1;}
.nav-item:hover{color:#fff;background:rgba(255,255,255,.12);transform:translateX(4px)}
.nav-item.active{color:#fff;background:rgba(255,255,255,.18);font-weight:600;transform:translateX(4px)}
.nav-item.active::before{content:'';position:absolute;left:0;top:50%;transform:translateY(-50%);width:3px;height:60%;background:#60a5fa;border-radius:0 3px 3px 0}
.nav-item .ni-badge{margin-left:auto;background:rgba(239,68,68,.8);color:#fff;font-size:.6rem;font-weight:700;padding:2px 6px;border-radius:10px;}
.sb-scroll{flex:1;overflow-y:auto;padding-bottom:20px}
.sb-scroll::-webkit-scrollbar{width:0}

.main{margin-left:var(--sidebar-w);min-height:100vh;padding-top:0px;}
.topbar{background:#fff;border-bottom:1px solid var(--border);padding:12px 28px;display:flex;align-items:center;justify-content:space-between;position:sticky;top:0px;z-index:30;}
.content{padding:36px 28px;}
.card{background:#fff;border-radius:16px;border:1px solid var(--border);transition:all .25s;}
.card:hover{box-shadow:0 8px 28px rgba(26,47,181,.1);transform:translateY(-2px)}
.btn{padding:9px 20px;border-radius:10px;font-weight:600;font-size:.85rem;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;}
.btn-primary{background:var(--blue);color:#fff}
.inp{width:100%;padding:10px 14px;border:1px solid var(--border);border-radius:10px;background:#f8faff;outline:none;font-size:.875rem;}
@media(max-width:768px){
  :root{--sidebar-w:0px}
  .sidebar{transform:translateX(-260px);width:260px;}
  .sidebar.open{transform:translateX(0);box-shadow:4px 0 30px rgba(0,0,0,.25)}
  .main{margin-left:0}
  #menu-btn{display:flex !important}
}
</style>
@stack('styles')
</head>
<body>

<div class="sidebar-overlay fixed inset-0 bg-black/50 z-30 hidden" id="sidebar-overlay" onclick="closeSidebar()"></div>

<!-- SIDEBAR -->
<aside class="sidebar" id="sidebar">
  <div class="sb-logo">
    <div class="sb-logo-img-wrap" style="width:42px;height:42px;border-radius:10px;background:#fff;display:flex;align-items:center;justify-content:center;">
      <div style="font-weight:bold;color:var(--blue);font-size:1.2rem">K</div>
    </div>
    <div>
      <div class="sb-logo-text">KSPM SV IPB</div>
      <div class="sb-logo-sub">Admin Dashboard</div>
    </div>
  </div>
  <div class="sb-admin-badge">
    <div class="sb-avatar">AD</div>
    <div>
      <div class="sb-admin-name">{{ Auth::user()->name ?? 'Admin KSPM' }}</div>
      <div class="sb-admin-role">Super Administrator</div>
    </div>
  </div>
  <div class="sb-scroll">
    <div class="nav-section text-xs font-bold tracking-widest text-white/35 px-5 pt-3.5 pb-1 uppercase">Overview</div>
    <a href="{{ url('/admin/dashboard') }}" class="nav-item {{ request()->is('admin/dashboard') ? 'active' : '' }}">
        <span class="ni-icon">🏠</span> Dashboard
    </a>
    <a href="{{ url('/admin/analitik') }}" class="nav-item {{ request()->is('admin/analitik') ? 'active' : '' }}">
        <span class="ni-icon">📉</span> Analitik Pengguna
    </a>

    <div class="nav-section text-xs font-bold tracking-widest text-white/35 px-5 pt-3.5 pb-1 uppercase">Konten & Data</div>
    <a href="{{ url('/admin/anggota') }}" class="nav-item {{ request()->is('admin/anggota*') ? 'active' : '' }}">
        <span class="ni-icon">👥</span> Manajemen Anggota
    </a>
    <a href="{{ url('/admin/kegiatan') }}" class="nav-item {{ request()->is('admin/kegiatan*') ? 'active' : '' }}">
        <span class="ni-icon">📅</span> Kegiatan & Event <span class="ni-badge">3</span>
    </a>
    <a href="{{ url('/admin/riset') }}" class="nav-item {{ request()->is('admin/riset*') ? 'active' : '' }}">
        <span class="ni-icon">📊</span> Riset & Publikasi
    </a>
    <a href="{{ url('/admin/faq') }}" class="nav-item {{ request()->is('admin/faq*') ? 'active' : '' }}">
        <span class="ni-icon">❓</span> Manajemen FAQ
    </a>

    <div class="nav-section text-xs font-bold tracking-widest text-white/35 px-5 pt-3.5 pb-1 uppercase">Halaman Landing</div>
    <a href="{{ url('/admin/home-content') }}" class="nav-item {{ request()->is('admin/home-content*') ? 'active' : '' }}">
        <span class="ni-icon">🏠</span> Home Content
    </a>
    <a href="{{ url('/admin/about-us') }}" class="nav-item {{ request()->is('admin/about-us*') ? 'active' : '' }}">
        <span class="ni-icon">🏛️</span> About / Tentang
    </a>
    <a href="{{ url('/admin/gallery') }}" class="nav-item {{ request()->is('admin/gallery*') ? 'active' : '' }}">
        <span class="ni-icon">🖼️</span> Gallery
    </a>

    <div class="nav-section text-xs font-bold tracking-widest text-white/35 px-5 pt-3.5 pb-1 uppercase">Tools</div>
    <a href="{{ url('/admin/kalkulator') }}" class="nav-item {{ request()->is('admin/kalkulator*') ? 'active' : '' }}">
        <span class="ni-icon">🧮</span> Kalkulator Saham
    </a>
    <a href="{{ url('/admin/kamus') }}" class="nav-item {{ request()->is('admin/kamus*') ? 'active' : '' }}">
        <span class="ni-icon">📖</span> Kamus Investasi
    </a>

    <div class="nav-section text-xs font-bold tracking-widest text-white/35 px-5 pt-3.5 pb-1 uppercase">Pengaturan</div>
    <a href="{{ url('/admin/pengaturan') }}" class="nav-item {{ request()->is('admin/pengaturan*') ? 'active' : '' }}">
        <span class="ni-icon">⚙️</span> Pengaturan
    </a>
    <a href="{{ url('/') }}" target="_blank" class="nav-item" style="color:rgba(255,255,255,.5)">
        <span class="ni-icon">🌐</span> Lihat Homepage
    </a>
  </div>
</aside>

<!-- MAIN -->
<div class="main">
  <!-- TOPBAR -->
  <div class="topbar">
    <div class="topbar-left flex items-center gap-3">
      <button class="btn btn-ghost btn-icon" onclick="toggleSidebar()" id="menu-btn" style="display:none; padding:4px 8px;">☰</button>
      <div>
        <div class="font-bold text-base text-gray-900">@yield('page-title')</div>
        <div class="text-xs text-gray-400">KSPM SV IPB / <span>@yield('page-breadcrumb')</span></div>
      </div>
    </div>
    <div class="topbar-right flex items-center gap-2.5">
      <div class="search-bar relative" style="width:220px">
        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">🔍</span>
        <input class="inp pl-9 py-1.5 text-sm" placeholder="Cari...">
      </div>
      <button class="btn btn-ghost" style="padding:6px 10px;" title="Notifikasi">🔔</button>
    </div>
  </div>

  <!-- CONTENT -->
  <div class="content">
    @yield('content')
  </div>
</div>

<script>
function toggleSidebar() {
  const sb = document.getElementById('sidebar');
  const ov = document.getElementById('sidebar-overlay');
  sb.classList.toggle('open');
  ov.classList.toggle('hidden');
  document.body.style.overflow = sb.classList.contains('open') ? 'hidden' : '';
}
function closeSidebar() {
  document.getElementById('sidebar').classList.remove('open');
  document.getElementById('sidebar-overlay').classList.add('hidden');
  document.body.style.overflow = '';
}
</script>
@stack('scripts')
</body>
</html>