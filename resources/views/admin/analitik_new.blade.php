@extends('layouts.admin')

@section('page-title', 'Analitik Pengguna')
@section('page-breadcrumb', 'Sistem Informasi Manajemen')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap" style="margin-bottom:24px">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">📉 Analitik Pengguna</div>
        <div class="section-sub text-sm text-gray-500">Statistik sistem informasi manajemen — data pengguna, fitur terpopuler & aktivitas website</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <select class="inp inp-sm" id="analitik-filter-periode" style="width:auto" onchange="window.location.href='?periode='+this.value">
            <option value="7" {{ $periode == 7 ? 'selected' : '' }}>7 Hari Terakhir</option>
            <option value="30" {{ $periode == 30 ? 'selected' : '' }}>30 Hari Terakhir</option>
            <option value="90" {{ $periode == 90 ? 'selected' : '' }}>3 Bulan Terakhir</option>
        </select>
        <button class="btn btn-outline border-blue-600 text-blue-700 bg-white btn-sm" onclick="location.reload()">🔄 Refresh</button>
    </div>
</div>

<!-- STATISTIK UTAMA -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" style="margin-bottom:24px">
    <div class="card p-6">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <div style="font-size:.75rem;color:#64748b;text-transform:uppercase;font-weight:600;margin-bottom:8px">Total Page Views</div>
                <div style="font-size:1.8rem;font-weight:800;color:#3b82f6">{{ number_format($stats['total_page_views']) }}</div>
                <div style="font-size:.75rem;color:#10b981;margin-top:4px">+{{ $stats['today_page_views'] }} hari ini</div>
            </div>
            <div style="font-size:2rem">👁</div>
        </div>
    </div>

    <div class="card p-6">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <div style="font-size:.75rem;color:#64748b;text-transform:uppercase;font-weight:600;margin-bottom:8px">User Terdaftar</div>
                <div style="font-size:1.8rem;font-weight:800;color:#8b5cf6">{{ number_format($stats['total_users']) }}</div>
                <div style="font-size:.75rem;color:#10b981;margin-top:4px">+{{ $stats['today_new_users'] }} hari ini</div>
            </div>
            <div style="font-size:2rem">👤</div>
        </div>
    </div>

    <div class="card p-6">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <div style="font-size:.75rem;color:#64748b;text-transform:uppercase;font-weight:600;margin-bottom:8px">Download Riset</div>
                <div style="font-size:1.8rem;font-weight:800;color:#f59e0b">{{ number_format($stats['total_report_downloads']) }}</div>
                <div style="font-size:.75rem;color:#64748b;margin-top:4px">dalam periode</div>
            </div>
            <div style="font-size:2rem">📊</div>
        </div>
    </div>

    <div class="card p-6">
        <div style="display:flex;justify-content:space-between;align-items:flex-start">
            <div>
                <div style="font-size:.75rem;color:#64748b;text-transform:uppercase;font-weight:600;margin-bottom:8px">Event Interactions</div>
                <div style="font-size:1.8rem;font-weight:800;color:#10b981">{{ number_format($stats['total_event_interactions']) }}</div>
                <div style="font-size:.75rem;color:#64748b;margin-top:4px">dalam periode</div>
            </div>
            <div style="font-size:2rem">🎯</div>
        </div>
    </div>
</div>

<!-- GRAFIK BARIS 1: User Registrasi -->
<div style="margin-bottom:24px">
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👤 Pertumbuhan User Registrasi</div>
                <div class="section-sub text-sm text-gray-500">User terdaftar per hari dalam {{ $periode }} hari terakhir</div>
            </div>
            <span class="badge badge-purple inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">Registrasi</span>
        </div>
        <div style="position:relative;height:250px">
            <canvas id="chartUserReg"></canvas>
        </div>
        <div class="mt-4 flex gap-4 flex-wrap">
            <div>
                <div style="font-size:.72rem;color:var(--muted)">Total Terdaftar</div>
                <div style="font-size:1.2rem;font-weight:800;color:#8b5cf6">{{ number_format($stats['total_users']) }}</div>
            </div>
            <div>
                <div style="font-size:.72rem;color:var(--muted)">Periode Ini</div>
                <div style="font-size:1.2rem;font-weight:800;color:#10b981">+{{ number_format($stats['total_registered_users']) }}</div>
            </div>
            <div>
                <div style="font-size:.72rem;color:var(--muted)">Rata-rata/hari</div>
                <div style="font-size:1.2rem;font-weight:800;color:#0ea5e9">{{ number_format(ceil($stats['total_registered_users'] / $periode)) }}</div>
            </div>
        </div>
    </div>
</div>

<!-- GRAFIK BARIS 2: View Harian & Fitur -->
<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:24px">
    <!-- Pengunjung Harian -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👁 Page Views Harian</div>
                <div class="section-sub text-sm text-gray-500">Jumlah page views per hari</div>
            </div>
        </div>
        <div style="position:relative;height:200px">
            <canvas id="chartViewHarian"></canvas>
        </div>
        <div class="mt-3.5 flex gap-4 flex-wrap">
            <div>
                <div style="font-size:.7rem;color:var(--muted)">Total Views</div>
                <div style="font-size:1.15rem;font-weight:800;color:var(--blue)" id="vstat-total">{{ number_format($stats['total_page_views']) }}</div>
            </div>
            <div>
                <div style="font-size:.7rem;color:var(--muted)">Rata-rata/hari</div>
                <div style="font-size:1.15rem;font-weight:800;color:#10b981" id="vstat-avg">{{ number_format(ceil($stats['total_page_views'] / $periode)) }}</div>
            </div>
            <div>
                <div style="font-size:.7rem;color:var(--muted)">Pengunjung Unik</div>
                <div style="font-size:1.15rem;font-weight:800;color:#f59e0b" id="vstat-peak">{{ number_format($stats['unique_visitors']) }}</div>
            </div>
        </div>
    </div>

    <!-- Fitur Paling Banyak Dipakai -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">⚡ Fitur Paling Banyak Dipakai</div>
                <div class="section-sub text-sm text-gray-500">Top 8 fitur yang paling sering digunakan</div>
            </div>
            <span class="badge badge-green inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Top Features</span>
        </div>
        <div id="chart-fitur" class="flex flex-col gap-3">
            @if($mostUsedFeatures->isEmpty())
                <div style="text-align:center;color:#94a3b8;padding:20px">Data belum tersedia</div>
            @else
                @php
                    $maxUsage = $mostUsedFeatures->max('total_usage');
                    $colors = ['#8b5cf6', '#10b981', '#f59e0b', '#6366f1', '#06b6d4', '#ec4899', '#eab308', '#14b8a6'];
                @endphp
                @foreach($mostUsedFeatures as $i => $feature)
                    <div class="fitur-row" style="animation-delay:{{ $i * 0.1 }}s">
                        <div class="fitur-info" style="flex:1">
                            <div class="fitur-name" style="margin-bottom:4px">{{ $feature->feature_name }}</div>
                            <div class="fitur-bar-track">
                                <div class="fitur-bar-fill" style="width:{{ ($feature->total_usage / $maxUsage) * 100 }}%;background:{{ $colors[$i % count($colors)] }}"></div>
                            </div>
                        </div>
                        <div class="fitur-pct">{{ number_format($feature->total_usage) }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>

<!-- GRAFIK BARIS 3: Riset & Event -->
<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:24px">
    <!-- Top Reports -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">📊 Riset Paling Banyak Didownload</div>
                <div class="section-sub text-sm text-gray-500">Top 10 riset/publikasi yang paling sering diakses</div>
            </div>
            <span class="badge badge-purple inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">Download</span>
        </div>
        <div style="position:relative;height:220px">
            <canvas id="chartReportDownloads"></canvas>
        </div>
        @if($topReports->isNotEmpty())
            <div style="margin-top:12px;display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--muted)">
                <span>📌 Terbanyak:</span>
                <strong style="color:#8b5cf6">{{ $topReports->first()->report_title }} — {{ number_format($topReports->first()->total_downloads) }} download</strong>
            </div>
        @endif
    </div>

    <!-- Top Events -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">🎯 Event Paling Banyak Diakses</div>
                <div class="section-sub text-sm text-gray-500">Top 10 event yang paling sering diklik/diakses</div>
            </div>
            <span class="badge badge-orange inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Interactions</span>
        </div>
        <div style="position:relative;height:220px">
            <canvas id="chartEventInteractions"></canvas>
        </div>
        @if($topEvents->isNotEmpty())
            <div style="margin-top:12px;display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--muted)">
                <span>🏆 Terbanyak:</span>
                <strong style="color:#f59e0b">{{ $topEvents->first()->event_name }} — {{ number_format($topEvents->first()->interaction_count) }} interactions</strong>
            </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
.fitur-row { display:flex; align-items:center; gap:10px; margin-bottom:8px; animation:fadeInRight .4s ease both; }
.fitur-icon { width:32px; height:32px; display:flex; justify-content:center; align-items:center; background:#f0f4ff; border-radius:8px; }
.fitur-info { flex:1; }
.fitur-name { font-size:0.85rem; font-weight:600; margin-bottom:4px; }
.fitur-bar-track { height:6px; background:#e2e8f0; border-radius:4px; overflow:hidden; }
.fitur-bar-fill { height:100%; border-radius:4px; transition:width 0.8s cubic-bezier(.4,0,.2,1); }
.fitur-pct { font-size:0.8rem; font-weight:700; width:50px; text-align:right; }
@keyframes fadeInRight { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// Persiapan Data dari Backend
const userRegData = @json($userRegistration->map(fn($u) => ['date' => $u->date, 'count' => $u->count]));
const pageViewsData = @json($pageViews->map(fn($p) => ['date' => $p->date, 'views' => $p->views, 'unique' => $p->unique_visitors]));
// 1. Lempar data mentah dari PHP ke JS
const rawReports = @json($topReports);

// 2. Lakukan mapping menggunakan standar JavaScript murni
const topReportsData = rawReports.map(r => {
    // Pastikan nama property (report_title & total_downloads) sesuai dengan hasil query SQL Anda
    const titleRaw = r.report_title || 'Tanpa Judul'; 
    return {
        title: titleRaw.substring(0, 20),
        full_title: titleRaw,
        downloads: parseInt(r.total_downloads || 0)
    };
});
const rawEvents = @json($topEvents);
const topEventsData = rawEvents.map(e => ({
    name: (e.event_name || 'Tanpa Nama').substring(0, 20),
    full_name: e.event_name || '',
    interactions: parseInt(e.interaction_count || 0)
}));
const chartOptions = {
    responsive: true,
    maintainAspectRatio: false,
    interaction: { mode: 'index', intersect: false },
    plugins: {
        legend: { display: false },
        tooltip: {
            backgroundColor: 'rgba(13,15,26,0.90)',
            padding: 12,
            cornerRadius: 10,
            callbacks: {
                label: function(context) {
                    let label = '';
                    if (context.dataset.label) label = context.dataset.label + ': ';
                    if (context.parsed.y !== null) label += number_format(context.parsed.y);
                    return label;
                }
            }
        }
    },
    scales: {
        x: {
            grid: { display: false },
            border: { display: false }
        },
        y: {
            beginAtZero: true,
            grid: { color: 'rgba(208,213,232,0.35)' },
            border: { display: false }
        }
    }
};

function number_format(num) {
    if (num >= 1000) return (num / 1000).toFixed(1) + 'K';
    return num.toString();
}

// Chart 1: User Registration
if (userRegData.length > 0) {
    const userRegCtx = document.getElementById('chartUserReg').getContext('2d');
    new Chart(userRegCtx, {
        type: 'line',
        data: {
            labels: userRegData.map(d => new Date(d.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' })),
            datasets: [{
                label: 'Registrasi User',
                data: userRegData.map(d => d.count),
                borderColor: '#8b5cf6',
                backgroundColor: 'rgba(139, 92, 246, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: '#8b5cf6',
                pointBorderColor: '#fff',
                pointBorderWidth: 2
            }]
        },
        options: chartOptions
    });
}

// Chart 2: Page Views
if (pageViewsData.length > 0) {
    const pageViewCtx = document.getElementById('chartViewHarian').getContext('2d');
    new Chart(pageViewCtx, {
        type: 'bar',
        data: {
            labels: pageViewsData.map(d => new Date(d.date).toLocaleDateString('id-ID', { day: '2-digit', month: 'short' })),
            datasets: [{
                label: 'Page Views',
                data: pageViewsData.map(d => d.views),
                backgroundColor: '#3b82f6',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: chartOptions
    });
}

// Chart 3: Report Downloads
if (topReportsData.length > 0) {
    const reportCtx = document.getElementById('chartReportDownloads').getContext('2d');
    new Chart(reportCtx, {
        type: 'bar',
        data: {
            labels: topReportsData.map(d => d.title),
            datasets: [{
                label: 'Downloads',
                data: topReportsData.map(d => d.downloads),
                backgroundColor: '#8b5cf6',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            ...chartOptions,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(208,213,232,0.35)' } },
                y: { grid: { display: false }, border: { display: false } }
            }
        }
    });
}

// Chart 4: Event Interactions
if (topEventsData.length > 0) {
    const eventCtx = document.getElementById('chartEventInteractions').getContext('2d');
    new Chart(eventCtx, {
        type: 'bar',
        data: {
            labels: topEventsData.map(d => d.name),
            datasets: [{
                label: 'Interactions',
                data: topEventsData.map(d => d.interactions),
                backgroundColor: '#f59e0b',
                borderRadius: 6,
                borderSkipped: false
            }]
        },
        options: {
            ...chartOptions,
            indexAxis: 'y',
            scales: {
                x: { beginAtZero: true, grid: { color: 'rgba(208,213,232,0.35)' } },
                y: { grid: { display: false }, border: { display: false } }
            }
        }
    });
}
</script>
@endpush
