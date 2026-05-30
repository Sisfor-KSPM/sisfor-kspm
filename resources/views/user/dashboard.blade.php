@extends('layouts.user')

@section('page-title', 'Dashboard')
@section('page-breadcrumb', 'Overview')

@section('content')
<!-- STAT CARDS -->
<div class="grid-4 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4" style="margin-bottom:20px">
    <div class="stat-card">
        <div class="flex items-center justify-between mb-2.5">
            <div style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase">Total Anggota</div>
            <div style="font-size:1.4rem">👥</div>
        </div>
        <div class="mono" style="font-size:2rem;font-weight:800;color:var(--blue)">247</div>
        <div style="font-size:.75rem;color:var(--success);margin-top:4px;font-weight:600">▲ +12 bulan ini</div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-2.5">
            <div style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase">Kegiatan Aktif</div>
            <div style="font-size:1.4rem">📅</div>
        </div>
        <div class="mono" style="font-size:2rem;font-weight:800;color:#0ea5e9">8</div>
        <div style="font-size:.75rem;color:var(--muted);margin-top:4px">3 upcoming</div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-2.5">
            <div style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase">Info Lomba</div>
            <div style="font-size:1.4rem">🏆</div>
        </div>
        <div class="mono" style="font-size:2rem;font-weight:800;color:#f59e0b">3</div>
        <div style="font-size:.75rem;color:var(--warn);margin-top:4px;font-weight:600">⚡ Deadline segera</div>
    </div>
    <div class="stat-card">
        <div class="flex items-center justify-between mb-2.5">
            <div style="font-size:.75rem;font-weight:700;color:var(--muted);text-transform:uppercase">Publikasi Riset</div>
            <div style="font-size:1.4rem">📊</div>
        </div>
        <div class="mono" style="font-size:2rem;font-weight:800;color:#10b981">24</div>
        <div style="font-size:.75rem;color:var(--success);margin-top:4px;font-weight:600">▲ +2 minggu ini</div>
    </div>
</div>

<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:20px">
    <!-- Aktivitas Terakhir -->
    <div class="card p-5">
        <div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap">
            <div>
                <div class="section-title text-lg font-bold text-gray-900">Aktivitas Terbaru</div>
                <div class="section-sub text-sm text-gray-500">Log perubahan terkini</div>
            </div>
        </div>
        <div id="activity-log">
            <div class="activity-item flex gap-3 py-3 border-b border-gray-100">
                <div class="activity-dot w-2 h-2 rounded-full bg-blue-600 shrink-0 mt-1.5"></div>
                <div>
                    <div style="font-size:.85rem;font-weight:600">Lomba Analisis Saham BEI ditambahkan</div>
                    <div style="font-size:.72rem;color:var(--muted)">Hari ini, 09.30 WIB · Admin</div>
                </div>
            </div>
            <div class="activity-item flex gap-3 py-3 border-b border-gray-100">
                <div class="activity-dot w-2 h-2 rounded-full bg-emerald-500 shrink-0 mt-1.5"></div>
                <div>
                    <div style="font-size:.85rem;font-weight:600">Anggota baru: Rafi Prasetyo</div>
                    <div style="font-size:.72rem;color:var(--muted)">Kemarin, 14.15 WIB · Admin</div>
                </div>
            </div>
            <div class="activity-item flex gap-3 py-3 border-b border-gray-100">
                <div class="activity-dot w-2 h-2 rounded-full bg-amber-500 shrink-0 mt-1.5"></div>
                <div>
                    <div style="font-size:.85rem;font-weight:600">Kegiatan SPM Batch 2 diperbarui</div>
                    <div style="font-size:.72rem;color:var(--muted)">2 hari lalu · Admin</div>
                </div>
            </div>
            <div class="activity-item flex gap-3 py-3 border-b border-gray-100">
                <div class="activity-dot w-2 h-2 rounded-full bg-sky-500 shrink-0 mt-1.5"></div>
                <div>
                    <div style="font-size:.85rem;font-weight:600">Riset Weekly Outlook Vol.12 dipublikasi</div>
                    <div style="font-size:.72rem;color:var(--muted)">3 hari lalu · Divisi Riset</div>
                </div>
            </div>
            <div class="activity-item flex gap-3 py-3 border-b border-gray-100 border-none">
                <div class="activity-dot w-2 h-2 rounded-full bg-purple-500 shrink-0 mt-1.5"></div>
                <div>
                    <div style="font-size:.85rem;font-weight:600">Pengumuman: Rekrutmen 2025 dibuka</div>
                    <div style="font-size:.72rem;color:var(--muted)">1 minggu lalu · Admin</div>
                </div>
            </div>
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
            <div><div style="font-size:.72rem;color:var(--muted)">Total Anggota</div><div style="font-size:1.3rem;font-weight:800;color:var(--blue)">247</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Rata-rata/bln</div><div style="font-size:1.3rem;font-weight:800;color:#10b981">+8</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Aktif</div><div style="font-size:1.3rem;font-weight:800;color:#0ea5e9">89%</div></div>
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
            <div class="section-sub text-sm text-gray-500">Statistik pengunjung, klik riset, dan klik event</div>
        </div>
        <div class="flex gap-1.5">
            <button class="btn btn-ghost btn-sm" onclick="switchChartView('harian')" id="btn-view-harian" style="border-color:var(--blue);color:var(--blue)">Harian</button>
            <button class="btn btn-ghost btn-sm" onclick="switchChartView('mingguan')" id="btn-view-mingguan">Mingguan</button>
        </div>
    </div>

    <!-- Row 1: Visitor harian & mingguan -->
    <div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:20px">
        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👁 Pengunjung Website</div>
                    <div class="section-sub text-sm text-gray-500" id="visitor-chart-sub">7 hari terakhir</div>
                </div>
                <span class="badge badge-blue inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-800" id="visitor-total-badge">Total: 1.842</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-visitor"></canvas>
            </div>
            <div class="mt-3.5 flex gap-5 flex-wrap">
                <div><div style="font-size:.72rem;color:var(--muted)">Rata-rata/hari</div><div style="font-size:1.2rem;font-weight:800;color:var(--blue)" id="visitor-avg">263</div></div>
                <div><div style="font-size:.72rem;color:var(--muted)">Puncak tertinggi</div><div style="font-size:1.2rem;font-weight:800;color:#10b981" id="visitor-peak">412</div></div>
                <div><div style="font-size:.72rem;color:var(--muted)">Trend</div><div style="font-size:1.2rem;font-weight:800;color:#f59e0b" id="visitor-trend">▲ +12%</div></div>
            </div>
        </div>

        <div class="card p-5">
            <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
                <div>
                    <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">📅 Kunjungan Mingguan</div>
                    <div class="section-sub text-sm text-gray-500">Perbandingan per minggu (4 minggu)</div>
                </div>
                <span class="badge badge-green inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Weekly</span>
            </div>
            <div class="relative h-[180px] w-full">
                <canvas id="chart-weekly"></canvas>
            </div>
            <div class="mt-3.5 flex gap-5 flex-wrap">
                <div><div style="font-size:.72rem;color:var(--muted)">Total bulan ini</div><div style="font-size:1.2rem;font-weight:800;color:var(--blue)">7.348</div></div>
                <div><div style="font-size:.72rem;color:var(--muted)">Minggu terbaik</div><div style="font-size:1.2rem;font-weight:800;color:#10b981">2.214</div></div>
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
                📌 Riset paling banyak dibaca: <strong style="color:var(--blue)">Weekly Outlook Vol.12</strong>
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
                🏆 Event paling banyak dilihat: <strong style="color:#f59e0b">SPM Batch 2 — 2025</strong>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// Data Setup
const visitorHarian = { labels: ['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'], data: [224, 318, 287, 352, 412, 195, 154] };
const visitorMingguan = { labels: ['Minggu 1','Minggu 2','Minggu 3','Minggu 4'], data: [1820, 2214, 1948, 1366] };
const risetKlikData = { labels: ['W.Outlook Vol.12','W.Outlook Vol.11','Analisis BBCA','Analisis GOTO','Screening April','W.Outlook Vol.10'], shortLabels: ['WO.12','WO.11','BBCA','GOTO','Apr','WO.10'], data: [412, 347, 298, 276, 231, 184] };
const eventKlikData = { labels: ['SPM Batch 2','Webinar IPO','Workshop TA','Seminar BEI','KSPM Cup','School of IPB'], shortLabels: ['SPM B2','Web.IPO','WS TA','Sem BEI','KSPM Cup','SoIPB'], data: [538, 421, 384, 312, 267, 195] };

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

// SVG Chart Function for Dashboard
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
    // Member SVG Chart
    const memberData = [{m:'Okt',v:190},{m:'Nov',v:205},{m:'Des',v:215},{m:'Jan',v:228},{m:'Feb',v:238},{m:'Mar',v:247}];
    renderLineChartSVG('member-chart', memberData, '#1a2fb5');

    // Chart.js Charts
    const c1 = document.getElementById('chart-visitor');
    chartVisitor = new Chart(c1, { type: 'line', data: { labels: visitorHarian.labels, datasets: [buildLineDataset(c1, visitorHarian.data, '#1a2fb5', 'Pengunjung')] }, options: sharedOptions({ callbacks: { label: ctx => `  Pengunjung: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const c2 = document.getElementById('chart-weekly');
    chartWeekly = new Chart(c2, { type: 'line', data: { labels: visitorMingguan.labels, datasets: [buildLineDataset(c2, visitorMingguan.data, '#10b981', 'Pengunjung')] }, options: sharedOptions({ callbacks: { label: ctx => `  Pengunjung: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const c3 = document.getElementById('chart-riset-click');
    chartRiset = new Chart(c3, { type: 'line', data: { labels: risetKlikData.shortLabels, datasets: [buildLineDataset(c3, risetKlikData.data, '#8b5cf6', 'Klik')] }, options: sharedOptions({ callbacks: { title: i => risetKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const c4 = document.getElementById('chart-event-click');
    chartEvent = new Chart(c4, { type: 'line', data: { labels: eventKlikData.shortLabels, datasets: [buildLineDataset(c4, eventKlikData.data, '#f59e0b', 'Klik')] }, options: sharedOptions({ callbacks: { title: i => eventKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });
});

function switchChartView(view) {
    const btnH = document.getElementById('btn-view-harian');
    const btnM = document.getElementById('btn-view-mingguan');
    if (view === 'harian') {
        btnH && (btnH.style.borderColor='var(--blue)', btnH.style.color='var(--blue)');
        btnM && (btnM.style.borderColor='', btnM.style.color='');
        if (chartVisitor) { chartVisitor.data.labels = visitorHarian.labels; chartVisitor.data.datasets[0].data = visitorHarian.data; chartVisitor.update(); }
    } else {
        btnM && (btnM.style.borderColor='var(--blue)', btnM.style.color='var(--blue)');
        btnH && (btnH.style.borderColor='', btnH.style.color='');
        if (chartVisitor) { chartVisitor.data.labels = visitorMingguan.labels; chartVisitor.data.datasets[0].data = visitorMingguan.data; chartVisitor.update(); }
    }
}
</script>
@endpush