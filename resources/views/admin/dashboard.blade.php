@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('page-breadcrumb', 'Overview')

@section('content')
<!-- STAT CARDS -->
<div class="grid-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-8">
    
    <!-- Card 1: Total Anggota -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group flex flex-col justify-between">
        <div class="absolute -right-4 -top-4 w-20 h-20 lg:w-24 lg:h-24 bg-blue-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <div class="text-[0.7rem] lg:text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Total Anggota</div>
            <div class="flex items-center justify-center w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-blue-50 text-blue-600 text-xl lg:text-2xl shadow-inner shrink-0">
                👥
            </div>
        </div>
        <div class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-1 relative z-10 break-words">{{ number_format($totalAnggota, 0, ',', '.') }}</div>
        <div class="flex flex-wrap items-center gap-1.5 mt-2 relative z-10">
            <span class="inline-flex items-center text-green-700 font-semibold bg-green-100/80 px-2 py-0.5 rounded-md text-[0.65rem] lg:text-xs border border-green-200 whitespace-nowrap">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                +{{ number_format($anggotaBulanIni, 0, ',', '.') }}
            </span>
            <span class="text-gray-400 font-medium text-[0.65rem] lg:text-xs leading-tight">Bulan ini</span>
        </div>
    </div>

    <!-- Card 2: Kegiatan Aktif -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group flex flex-col justify-between">
        <div class="absolute -right-4 -top-4 w-20 h-20 lg:w-24 lg:h-24 bg-sky-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <div class="text-[0.7rem] lg:text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Kegiatan Aktif</div>
            <div class="flex items-center justify-center w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-sky-50 text-sky-500 text-xl lg:text-2xl shadow-inner shrink-0">
                📅
            </div>
        </div>
        <div class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-1 relative z-10 break-words">{{ number_format($kegiatanAktif, 0, ',', '.') }}</div>
        <div class="flex flex-wrap items-center gap-1.5 mt-2 relative z-10">
            <span class="inline-flex items-center text-sky-700 font-semibold bg-sky-100/80 px-2 py-0.5 rounded-md text-[0.65rem] lg:text-xs border border-sky-200 whitespace-nowrap">
                {{ number_format($upcomingKegiatan, 0, ',', '.') }}
            </span>
            <span class="text-gray-400 font-medium text-[0.65rem] lg:text-xs leading-tight">Upcoming</span>
        </div>
    </div>

    <!-- Card 3: Info Lomba -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group flex flex-col justify-between">
        <div class="absolute -right-4 -top-4 w-20 h-20 lg:w-24 lg:h-24 bg-amber-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <div class="text-[0.7rem] lg:text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Info Lomba</div>
            <div class="flex items-center justify-center w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-amber-50 text-amber-500 text-xl lg:text-2xl shadow-inner shrink-0">
                🏆
            </div>
        </div>
        <div class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-1 relative z-10 break-words">{{ number_format($infoLomba, 0, ',', '.') }}</div>
        <div class="flex flex-wrap items-center gap-1.5 mt-2 relative z-10">
            <span class="inline-flex items-center text-amber-700 font-semibold bg-amber-100/80 px-2 py-0.5 rounded-md text-[0.65rem] lg:text-xs border border-amber-200 whitespace-nowrap">
                ⚡ Segera
            </span>
        </div>
    </div>

    <!-- Card 4: Publikasi Riset -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 lg:p-6 hover:shadow-md transition-shadow duration-300 relative overflow-hidden group flex flex-col justify-between">
        <div class="absolute -right-4 -top-4 w-20 h-20 lg:w-24 lg:h-24 bg-emerald-50 rounded-full opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
        <div class="flex items-start justify-between mb-3 relative z-10">
            <div class="text-[0.7rem] lg:text-xs font-bold text-gray-500 uppercase tracking-wider mt-1">Publikasi Riset</div>
            <div class="flex items-center justify-center w-10 h-10 lg:w-12 lg:h-12 rounded-xl bg-emerald-50 text-emerald-500 text-xl lg:text-2xl shadow-inner shrink-0">
                📊
            </div>
        </div>
        <div class="text-2xl lg:text-3xl font-extrabold text-gray-900 mb-1 relative z-10 break-words">{{ number_format($totalRiset, 0, ',', '.') }}</div>
        <div class="flex flex-wrap items-center gap-1.5 mt-2 relative z-10">
            <span class="inline-flex items-center text-emerald-700 font-semibold bg-emerald-100/80 px-2 py-0.5 rounded-md text-[0.65rem] lg:text-xs border border-emerald-200 whitespace-nowrap">
                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                +{{ number_format($risetMingguIni, 0, ',', '.') }}
            </span>
            <span class="text-gray-400 font-medium text-[0.65rem] lg:text-xs leading-tight">Minggu ini</span>
        </div>
    </div>

</div>

<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
    <!-- Aktivitas Terakhir -->
    <div class="card p-5">
        <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
            <div>
                <div class="section-title text-lg font-bold text-gray-900">Aktivitas Terbaru</div>
                <div class="section-sub text-sm text-gray-500">Log perubahan terkini</div>
            </div>
        </div>
        <div id="activity-log">
            @forelse ($recentActivities as $activity)
                @php
                    $act = strtolower($activity->action ?: $activity->activity_type ?: '');
                    if (str_contains($act, 'create') || str_contains($act, 'upload')) $act = 'create';
                    elseif (str_contains($act, 'update')) $act = 'update';
                    elseif (str_contains($act, 'delete')) $act = 'delete';

                    [$dotColor, $badgeBg, $badgeColor, $badgeIcon, $badgeText] = match($act) {
                        'create'  => ['#16a34a', '#dcfce7', '#15803d', '+', 'Ditambahkan'],
                        'update'  => ['#2563eb', '#dbeafe', '#1d4ed8', '✎', 'Diperbarui'],
                        'delete'  => ['#dc2626', '#fee2e2', '#b91c1c', '✕', 'Dihapus'],
                        default   => ['#94a3b8', '#f1f5f9', '#475569', '•', 'Aktivitas'],
                    };
                @endphp
                <div class="activity-item flex gap-3 py-3 border-b border-gray-100 {{ $loop->last ? 'border-none' : '' }}">
                    <div style="width:8px;height:8px;border-radius:50%;background:{{ $dotColor }};flex-shrink:0;margin-top:6px"></div>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;align-items:baseline;gap:6px;flex-wrap:wrap">
                            <span style="display:inline-flex;align-items:center;gap:3px;font-size:.67rem;font-weight:700;padding:2px 8px;border-radius:999px;background:{{ $badgeBg }};color:{{ $badgeColor }};white-space:nowrap;flex-shrink:0">{{ $badgeIcon }} {{ $badgeText }}</span>
                            <span style="font-size:.85rem;font-weight:600;color:#111827;word-break:break-word">{{ $activity->formatted_description }}</span>
                        </div>
                        <div style="font-size:.72rem;color:var(--muted);margin-top:3px">
                            {{ $activity->created_at?->diffForHumans() }}&nbsp;·&nbsp;<span style="font-weight:500">{{ $activity->user->name ?? 'Guest' }}</span>
                        </div>
                    </div>
                </div>
            @empty
                <div style="font-size:.85rem;color:var(--muted);padding:12px 0">Belum ada aktivitas Create / Update / Delete terbaru.</div>
            @endforelse
        </div>
    </div>

    <!-- Chart Anggota — LINE CHART SVG -->
    <div class="card p-5">
        <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
            <div>
                <div class="section-title text-lg font-bold text-gray-900">Pertumbuhan Anggota</div>
                <div class="section-sub text-sm text-gray-500">6 bulan terakhir</div>
            </div>
            <span class="badge badge-blue inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800">Line Chart</span>
        </div>
        <div style="width:100%;overflow:hidden" id="member-chart"></div>
        <div class="mt-3.5 flex gap-5 flex-wrap">
            <div><div style="font-size:.72rem;color:var(--muted)">Total Anggota</div><div style="font-size:1.3rem;font-weight:800;color:var(--blue)">{{ number_format($totalAnggota, 0, ',', '.') }}</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Rata-rata/bln</div><div style="font-size:1.3rem;font-weight:800;color:#10b981">{{ number_format($memberAverageGrowth, 0, ',', '.') }}</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Terverifikasi</div><div style="font-size:1.3rem;font-weight:800;color:#0ea5e9">{{ $activeMemberPercentage }}%</div></div>
        </div>
    </div>
</div>

<!-- Quick Access -->
<div class="card p-5 mb-5">
    <div class="section-title text-lg font-bold text-gray-900" style="margin-bottom:16px">Quick Access</div>
    <div class="flex gap-2.5 flex-wrap">
        <a href="{{ url('admin/lomba') }}" class="btn btn-primary text-sm">🏆 Tambah Lomba</a>
        <a href="{{ url('admin/anggota') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">👤 Tambah Anggota</a>
        <a href="{{ url('admin/kegiatan') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">📅 Buat Kegiatan</a>
        <a href="{{ url('admin/riset') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">📊 Upload Riset</a>
        <a href="{{ url('admin/pengumuman') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">📢 Buat Pengumuman</a>
        <a href="{{ url('admin/gallery') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">🖼️ Upload Foto</a>
        <a href="{{ url('admin/rekrutmen') }}" class="btn btn-outline border-blue-600 text-blue-700 bg-white text-sm">🎯 Buka Rekrutmen</a>
        <a href="{{ url('admin/kalkulator') }}" class="btn btn-ghost border-gray-300 text-gray-600 bg-white text-sm">🧮 Kalkulator Saham</a>
    </div>
</div>

<!-- GRAFIK TAMBAHAN DASHBOARD -->
<div style="margin-top:20px">
    <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
        <div>
            <div class="section-title text-lg font-bold text-gray-900">📊 Grafik Analitik Website</div>
            <div class="section-sub text-sm text-gray-500">Statistik kunjungan website dan klik publikasi</div>
        </div>
        <!-- SWITCH FILTER: MINGGUAN & BULANAN -->
        <div class="flex gap-1.5" style="background:#f1f5f9; padding:4px; border-radius:8px;">
            <button class="btn btn-ghost btn-sm" onclick="switchChartView('mingguan')" id="btn-view-mingguan" style="background:#fff; border-color:var(--blue); color:var(--blue); box-shadow:0 1px 2px rgba(0,0,0,0.05)">Mingguan</button>
            <button class="btn btn-ghost btn-sm" onclick="switchChartView('bulanan')" id="btn-view-bulanan" style="color:var(--muted)">Bulanan</button>
        </div>
    </div>

    <!-- Row 1: Kunjungan Website (Filterable) -->
    <div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:20px">
        
        <!-- GRAFIK KIRI (Pengunjung Website) -->
        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👁 Pengunjung Website</div>
                    <div class="section-sub text-sm text-gray-500" id="visitor-chart-sub">4 minggu terakhir</div>
                </div>
                <span class="badge badge-blue inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800" id="visitor-total-badge">Total: {{ number_format($chartData['weeklyTotal'], 0, ',', '.') }}</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-visitor"></canvas>
            </div>
            <div class="mt-3.5 flex gap-5 flex-wrap">
                <div><div style="font-size:.72rem;color:var(--muted)">Rata-rata/periode</div><div style="font-size:1.2rem;font-weight:800;color:var(--blue)" id="visitor-avg">{{ number_format($chartData['weeklyAvg'], 0, ',', '.') }}</div></div>
                <div><div style="font-size:.72rem;color:var(--muted)">Puncak tertinggi</div><div style="font-size:1.2rem;font-weight:800;color:#10b981" id="visitor-peak">{{ number_format($chartData['weeklyPeak'], 0, ',', '.') }}</div></div>
            </div>
        </div>

        <!-- GRAFIK KANAN (Kunjungan Perbandingan) -->
        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <!-- Judul grafik akan terganti dinamis mengikuti filter -->
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem" id="weekly-title">📅 Kunjungan Mingguan</div>
                    <div class="section-sub text-sm text-gray-500" id="weekly-sub">Perbandingan per minggu (4 minggu)</div>
                </div>
                <span class="badge badge-green inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800" id="weekly-badge">Weekly</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-weekly"></canvas>
            </div>
            <div class="mt-3.5 flex gap-5 flex-wrap">
                <div><div style="font-size:.72rem;color:var(--muted)">Total Kunjungan</div><div style="font-size:1.2rem;font-weight:800;color:var(--blue)" id="weekly-total">{{ number_format($chartData['weeklyTotal'], 0, ',', '.') }}</div></div>
                <div><div style="font-size:.72rem;color:var(--muted)">Puncak Kunjungan</div><div style="font-size:1.2rem;font-weight:800;color:#10b981" id="weekly-peak-right">{{ number_format($chartData['weeklyPeak'], 0, ',', '.') }}</div></div>
            </div>
        </div>
    </div>

    <!-- Row 2: Klik riset & event -->
    <div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5 mb-5">
        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">📊 Klik per Riset & Publikasi</div>
                    <div class="section-sub text-sm text-gray-500">Jumlah pembaca per publikasi riset</div>
                </div>
                <span class="badge badge-purple inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">Trigger Klik</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-riset-click"></canvas>
            </div>
            <div style="margin-top:14px;font-size:.78rem;color:var(--muted)">
                Riset paling banyak dibaca: <strong style="color:var(--blue)">{{ $chartData['topRisetTitle'] }}</strong>
            </div>
        </div>

        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">🎯 Klik per Event</div>
                    <div class="section-sub text-sm text-gray-500">Jumlah orang yang melihat per event</div>
                </div>
                <span class="badge badge-orange inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Trigger Klik</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-event-click"></canvas>
            </div>
            <div style="margin-top:14px;font-size:.78rem;color:var(--muted)">
                Event paling banyak dilihat: <strong style="color:#f59e0b">{{ $chartData['topEventTitle'] }}</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// JSON Data Parsing dari Controller
const visitorMingguanRaw = @json($chartData['visitorMingguan']);
const visitorBulananRaw = @json($chartData['visitorBulanan']);
const risetKlikRaw = @json($chartData['risetKlikData']);
const eventKlikRaw = @json($chartData['eventKlikData']);
const memberChartRaw = @json($memberChartData);

const shortLabel = label => (label || '-').length > 12 ? (label || '-').slice(0, 12) + '...' : (label || '-');

// Setup Mapping Dataset
const dataMingguan = { 
    labels: visitorMingguanRaw.map(i => i.label), 
    values: visitorMingguanRaw.map(i => Number(i.value || 0))
};
const dataBulanan = { 
    labels: visitorBulananRaw.map(i => i.label), 
    values: visitorBulananRaw.map(i => Number(i.value || 0))
};

const risetKlikData = { labels: risetKlikRaw.map(item => item.title), shortLabels: risetKlikRaw.map(item => shortLabel(item.title)), data: risetKlikRaw.map(item => Number(item.views || 0)) };
const eventKlikData = { labels: eventKlikRaw.map(item => item.title), shortLabels: eventKlikRaw.map(item => shortLabel(item.title)), data: eventKlikRaw.map(item => Number(item.views || 0)) };

// Data UI Switcher (Kunjungan Asli)
const statsData = {
    mingguan: {
        total: "{{ number_format($chartData['weeklyTotal'], 0, ',', '.') }}",
        avg: "{{ number_format($chartData['weeklyAvg'], 0, ',', '.') }}",
        peak: "{{ number_format($chartData['weeklyPeak'], 0, ',', '.') }}",
        sub: "4 minggu terakhir",
        rightTitle: "📅 Kunjungan Mingguan",
        rightSub: "Perbandingan per minggu (4 minggu)",
        rightBadge: "Weekly"
    },
    bulanan: {
        total: "{{ number_format($chartData['monthlyTotal'], 0, ',', '.') }}",
        avg: "{{ number_format($chartData['monthlyAvg'], 0, ',', '.') }}",
        peak: "{{ number_format($chartData['monthlyPeak'], 0, ',', '.') }}",
        sub: "6 bulan terakhir",
        rightTitle: "📅 Kunjungan Bulanan",
        rightSub: "Perbandingan per bulan (6 bulan)",
        rightBadge: "Monthly"
    }
};

function hexToRgb(hex) { return [parseInt(hex.slice(1,3),16), parseInt(hex.slice(3,5),16), parseInt(hex.slice(5,7),16)].join(','); }
function buildGradient(canvasEl, hex, alpha1=0.22, alpha2=0) {
    const ctx = canvasEl.getContext('2d');
    const h = canvasEl.parentElement ? canvasEl.parentElement.offsetHeight : 200;
    const grad = ctx.createLinearGradient(0, 0, 0, h || 200);
    grad.addColorStop(0, `rgba(${hexToRgb(hex)},${alpha1})`);
    grad.addColorStop(1, `rgba(${hexToRgb(hex)},${alpha2})`);
    return grad;
}

function buildLineDataset(canvasEl, data, color, label) {
    return {
        label: label || 'Data', data, borderColor: color, borderWidth: 2.5,
        backgroundColor: buildGradient(canvasEl, color), pointBackgroundColor: color,
        pointBorderColor: '#fff', pointBorderWidth: 2, pointRadius: 4, tension: 0.42, fill: true,
    };
}

const sharedOptions = (extraTooltip={}) => ({
    responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
    plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(13,15,26,0.90)', padding: 12, cornerRadius: 10, ...extraTooltip } },
    scales: { x: { grid: { display: false }, border: { display: false } }, y: { beginAtZero: true, grid: { color: 'rgba(208,213,232,0.35)' }, border: { display: false } } }
});

// Konstruktor Line Chart SVG internal untuk Pertumbuhan Anggota
function renderLineChartSVG(containerId, data, color1) {
    const el = document.getElementById(containerId);
    if (!el) return;
    const W = el.offsetWidth || 340, H = 150;
    const pad = {t:20,r:16,b:30,l:38};
    const cw = W - pad.l - pad.r, ch = H - pad.t - pad.b;
    const min = Math.min(...data.map(d=>d.v)), max = Math.max(...data.map(d=>d.v));
    const range = max - min || 1;
    const xs = data.map((_,i)=> pad.l + (i/(data.length-1))*cw);
    const ys = data.map(d=> pad.t + ch - ((d.v - min)/range)*ch);
    const line = xs.map((x,i)=>`${i===0?'M':'L'}${x.toFixed(1)},${ys[i].toFixed(1)}`).join(' ');
    const area = `${line} L${xs[xs.length-1].toFixed(1)},${(pad.t+ch).toFixed(1)} L${xs[0].toFixed(1)},${(pad.t+ch).toFixed(1)} Z`;
    const yTicks = [0,0.5,1].map(f=>({y:pad.t+ch-f*ch,v:Math.round(min+f*range)}));
    const gradId='grad-'+containerId.replace(/[^a-z]/gi,'');
    el.innerHTML=`<svg viewBox="0 0 ${W} ${H}" style="width:100%;height:${H}px;display:block;overflow:visible">
        <defs><linearGradient id="${gradId}" x1="0" y1="0" x2="0" y2="1"><stop offset="0%" stop-color="${color1}" stop-opacity="0.2"/><stop offset="100%" stop-color="${color1}" stop-opacity="0.01"/></linearGradient></defs>
        ${yTicks.map(t=>`<line x1="${pad.l}" y1="${t.y.toFixed(1)}" x2="${(W-pad.r).toFixed(1)}" y2="${t.y.toFixed(1)}" stroke="#e8ecfb" stroke-width="1"/><text x="${(pad.l-5).toFixed(1)}" y="${t.y.toFixed(1)}" text-anchor="end" dominant-baseline="middle" fill="#94a3b8" font-size="9" font-family="monospace">${t.v}</text>`).join('')}
        ${data.map((d,i)=>`<text x="${xs[i].toFixed(1)}" y="${(H-4).toFixed(1)}" text-anchor="middle" fill="#94a3b8" font-size="9" font-family="sans-serif">${d.m}</text>`).join('')}
        <path d="${area}" fill="url(#${gradId})"/><path d="${line}" fill="none" stroke="${color1}" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"></path>
        ${data.map((d,i)=>`<circle cx="${xs[i].toFixed(1)}" cy="${ys[i].toFixed(1)}" r="4.5" fill="${color1}" stroke="#fff" stroke-width="2.5"></circle>`).join('')}
    </svg>`;
}

let chartVisitor, chartWeekly, chartRiset, chartEvent;

document.addEventListener('DOMContentLoaded', () => {
    renderLineChartSVG('member-chart', memberChartRaw, '#1a2fb5');

    // Chart Pengunjung (Kiri - Biru)
    const c1 = document.getElementById('chart-visitor');
    chartVisitor = new Chart(c1, { 
        type: 'line', 
        data: { labels: dataMingguan.labels, datasets: [buildLineDataset(c1, dataMingguan.values, '#1a2fb5', 'Pengunjung')] }, 
        options: sharedOptions({ callbacks: { label: ctx => `  Pengunjung: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) 
    });

    // Chart Kunjungan Asli (Kanan - Hijau)
    const c2 = document.getElementById('chart-weekly');
    chartWeekly = new Chart(c2, { 
        type: 'line', 
        data: { labels: dataMingguan.labels, datasets: [buildLineDataset(c2, dataMingguan.values, '#10b981', 'Kunjungan')] }, 
        options: sharedOptions({ callbacks: { label: ctx => `  Kunjungan: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) 
    });

    const c3 = document.getElementById('chart-riset-click');
    chartRiset = new Chart(c3, { type: 'line', data: { labels: risetKlikData.shortLabels, datasets: [buildLineDataset(c3, risetKlikData.data, '#8b5cf6', 'Klik')] }, options: sharedOptions({ callbacks: { title: i => risetKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const c4 = document.getElementById('chart-event-click');
    chartEvent = new Chart(c4, { type: 'line', data: { labels: eventKlikData.shortLabels, datasets: [buildLineDataset(c4, eventKlikData.data, '#f59e0b', 'Klik')] }, options: sharedOptions({ callbacks: { title: i => eventKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });
});

// LOGIKA FILTER MINGGUAN / BULANAN (Sinkronisasi Grafik Pengunjung)
function switchChartView(view) {
    const btnM = document.getElementById('btn-view-mingguan');
    const btnB = document.getElementById('btn-view-bulanan');
    
    // UI Label Elements (Kiri)
    const vTotal = document.getElementById('visitor-total-badge');
    const vAvg = document.getElementById('visitor-avg');
    const vPeak = document.getElementById('visitor-peak');
    const vSub = document.getElementById('visitor-chart-sub');
    
    // UI Label Elements (Kanan)
    const wTitle = document.getElementById('weekly-title');
    const wSub = document.getElementById('weekly-sub');
    const wBadge = document.getElementById('weekly-badge');
    const wTotal = document.getElementById('weekly-total');
    const wPeak = document.getElementById('weekly-peak-right');

    const d = view === 'mingguan' ? dataMingguan : dataBulanan;
    const s = view === 'mingguan' ? statsData.mingguan : statsData.bulanan;

    // Toggle Style Button
    if (view === 'mingguan') {
        btnM && (btnM.style.background='#fff', btnM.style.borderColor='var(--blue)', btnM.style.color='var(--blue)', btnM.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)');
        btnB && (btnB.style.background='transparent', btnB.style.borderColor='transparent', btnB.style.color='var(--muted)', btnB.style.boxShadow='none');
    } else {
        btnB && (btnB.style.background='#fff', btnB.style.borderColor='var(--blue)', btnB.style.color='var(--blue)', btnB.style.boxShadow='0 1px 2px rgba(0,0,0,0.05)');
        btnM && (btnM.style.background='transparent', btnM.style.borderColor='transparent', btnM.style.color='var(--muted)', btnM.style.boxShadow='none');
    }
    
    // Update Chart Data
    if (chartVisitor) { chartVisitor.data.labels = d.labels; chartVisitor.data.datasets[0].data = d.values; chartVisitor.update(); }
    if (chartWeekly) { chartWeekly.data.labels = d.labels; chartWeekly.data.datasets[0].data = d.values; chartWeekly.update(); }
    
    // Update Teks Data (Kiri)
    vTotal && (vTotal.innerText = 'Total: ' + s.total);
    vAvg && (vAvg.innerText = s.avg);
    vPeak && (vPeak.innerText = s.peak);
    vSub && (vSub.innerText = s.sub);
    
    // Update Teks Data (Kanan)
    wTitle && (wTitle.innerText = s.rightTitle);
    wSub && (wSub.innerText = s.rightSub);
    wBadge && (wBadge.innerText = s.rightBadge);
    wTotal && (wTotal.innerText = s.total);
    wPeak && (wPeak.innerText = s.peak);
}
</script>
@endpush