@extends('layouts.admin')

@section('page-title', 'Analitik Pengguna')
@section('page-breadcrumb', 'Sistem Informasi Manajemen')

@section('content')
<div class="section-header flex items-center justify-between mb-5 mt-2 gap-3 flex-wrap" style="margin-bottom:24px">
    <div>
        <div class="section-title text-lg font-bold text-gray-900">📉 Analitik Pengguna</div>
        <div class="section-sub text-sm text-gray-500">Statistik sistem informasi manajemen — data pengguna, emiten favorit & fitur terpopuler</div>
    </div>
    <div class="flex gap-2 flex-wrap">
        <select class="inp inp-sm" id="analitik-filter-periode" style="width:auto">
            <option value="30">30 Hari Terakhir</option>
            <option value="7">7 Hari Terakhir</option>
            <option value="90">3 Bulan Terakhir</option>
        </select>
        <button class="btn btn-outline border-blue-600 text-blue-700 bg-white btn-sm">🔄 Refresh</button>
    </div>
</div>

<!-- GRAFIK BARIS 1: User Registrasi -->
<div style="margin-bottom:24px">
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👤 Pertumbuhan User Registrasi</div>
                <div class="section-sub text-sm text-gray-500">User terdaftar (bukan anggota KSPM) per bulan</div>
            </div>
            <span class="badge badge-purple inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">Non-Anggota</span>
        </div>
        <!-- LINE Chart User Registrasi SVG -->
        <div style="width:100%;overflow:hidden" id="chart-user-reg"></div>
        <div class="mt-4 flex gap-4 flex-wrap">
            <div><div style="font-size:.72rem;color:var(--muted)">Total Terdaftar</div><div style="font-size:1.2rem;font-weight:800;color:#8b5cf6">183</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Bulan ini</div><div style="font-size:1.2rem;font-weight:800;color:#10b981">+24</div></div>
            <div><div style="font-size:.72rem;color:var(--muted)">Rata-rata/bln</div><div style="font-size:1.2rem;font-weight:800;color:#0ea5e9">+14</div></div>
        </div>
    </div>
</div>

<!-- GRAFIK BARIS 2: View Harian & Mingguan -->
<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:24px">
    <!-- Pengunjung Harian -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">👁 View Harian Website</div>
                <div class="section-sub text-sm text-gray-500">Jumlah orang yang membuka website per hari (7 hari)</div>
            </div>
            <div style="display:flex;gap:5px">
                <button class="btn btn-ghost btn-sm" onclick="toggleViewChart('harian')" id="vbtn-harian" style="border-color:var(--blue);color:var(--blue);font-size:.7rem">Harian</button>
                <button class="btn btn-ghost btn-sm" onclick="toggleViewChart('mingguan')" id="vbtn-mingguan" style="font-size:.7rem">Mingguan</button>
            </div>
        </div>
        <div style="position:relative;height:200px">
            <canvas id="chartViewHarian"></canvas>
        </div>
        <div class="mt-3.5 flex gap-4 flex-wrap">
            <div><div style="font-size:.7rem;color:var(--muted)">Total 7 Hari</div><div style="font-size:1.15rem;font-weight:800;color:var(--blue)" id="vstat-total">1.942</div></div>
            <div><div style="font-size:.7rem;color:var(--muted)">Rata-rata/hari</div><div style="font-size:1.15rem;font-weight:800;color:#10b981" id="vstat-avg">277</div></div>
            <div><div style="font-size:.7rem;color:var(--muted)">Puncak</div><div style="font-size:1.15rem;font-weight:800;color:#f59e0b" id="vstat-peak">412</div></div>
        </div>
    </div>

    <!-- Fitur Paling Banyak Dipakai -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap mb-4">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">⚡ Fitur Paling Banyak Dipakai</div>
                <div class="section-sub text-sm text-gray-500">Penggunaan fitur platform oleh semua user</div>
            </div>
            <span class="badge badge-green inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-green-100 text-green-800">Analytics</span>
        </div>
        <div id="chart-fitur" class="flex flex-col gap-3"></div>
        <div style="margin-top:18px;display:flex;gap:10px;flex-wrap:wrap" id="fitur-legend"></div>
    </div>
</div>

<!-- GRAFIK BARIS 3: Klik Riset & Klik Event -->
<div class="grid-2 grid grid-cols-1 lg:grid-cols-2 gap-5" style="margin-bottom:24px">
    <!-- Klik per Riset Publikasi -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">📊 Trigger Klik — Riset & Publikasi</div>
                <div class="section-sub text-sm text-gray-500">Jumlah orang yang melihat per judul riset/publikasi</div>
            </div>
            <span class="badge badge-purple inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-violet-100 text-violet-800">Klik</span>
        </div>
        <div style="position:relative;height:220px">
            <canvas id="chartRisetKlik"></canvas>
        </div>
        <div style="margin-top:12px;display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--muted)">
            <span>📌 Terbanyak:</span>
            <strong style="color:#8b5cf6">Weekly Outlook Vol.12 — 412 klik</strong>
        </div>
    </div>

    <!-- Klik per Event -->
    <div class="card p-6">
        <div class="section-header flex items-center justify-between mt-2 gap-3 flex-wrap" style="margin-bottom:16px">
            <div>
                <div class="section-title text-lg font-bold text-gray-900" style="font-size:.95rem">🎯 Trigger Klik — Event KSPM</div>
                <div class="section-sub text-sm text-gray-500">Jumlah orang yang melihat per event/kegiatan</div>
            </div>
            <span class="badge badge-orange inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">Klik</span>
        </div>
        <div style="position:relative;height:220px">
            <canvas id="chartEventKlik"></canvas>
        </div>
        <div style="margin-top:12px;display:flex;align-items:center;gap:8px;font-size:.78rem;color:var(--muted)">
            <span>🏆 Terbanyak:</span>
            <strong style="color:#f59e0b">SPM Batch 2 — 538 klik</strong>
        </div>
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
.fitur-pct { font-size:0.8rem; font-weight:700; width:40px; text-align:right; }
.fitur-legend-item { font-size:0.75rem; color:#64748b; display:flex; align-items:center; gap:4px; }
.fitur-legend-dot { width:8px; height:8px; border-radius:50%; }
@keyframes fadeInRight { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
// Data Setup
const analitikViewHarian = { labels: ['Sen','Sel','Rab','Kam','Jum','Sab','Min'], data: [224, 318, 287, 352, 412, 195, 154] };
const analitikViewMingguan = { labels: ['Mgg 1','Mgg 2','Mgg 3','Mgg 4'], data: [1820, 2214, 1948, 1366] };
const risetKlikData = { labels: ['W.Outlook Vol.12','W.Outlook Vol.11','Analisis BBCA','Analisis GOTO','Screening April','W.Outlook Vol.10'], shortLabels: ['WO.12','WO.11','BBCA','GOTO','Apr','WO.10'], data: [412, 347, 298, 276, 231, 184] };
const eventKlikData = { labels: ['SPM Batch 2','Webinar IPO','Workshop TA','Seminar BEI','KSPM Cup','School of IPB'], shortLabels: ['SPM B2','Web.IPO','WS TA','Sem BEI','KSPM Cup','SoIPB'], data: [538, 421, 384, 312, 267, 195] };
const fiturData = [
    {icon:'🧮', name:'Kalkulator Saham', usage:2840, color:'#8b5cf6'},
    {icon:'📊', name:'Riset & Publikasi', usage:1640, color:'#10b981'},
    {icon:'🏆', name:'Kegiatan & event', usage:1280, color:'#f59e0b'},
    {icon:'📖', name:'Kamus Investasi', usage:1050, color:'#6366f1'},
];
const userRegData = [{m:'Nov', v:8}, {m:'Des', v:11}, {m:'Jan', v:14}, {m:'Feb', v:19}, {m:'Mar', v:16}, {m:'Apr', v:24}];

let chartAViewH, chartARiset, chartAEvent;
let analitikViewMode = 'harian';

function hexToRgb(hex) { return [parseInt(hex.slice(1,3),16), parseInt(hex.slice(3,5),16), parseInt(hex.slice(5,7),16)].join(','); }
function buildGradient(canvasEl, hex, alpha1=0.22, alpha2=0) {
    const ctx = canvasEl.getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 200);
    grad.addColorStop(0, `rgba(${hexToRgb(hex)},${alpha1})`);
    grad.addColorStop(1, `rgba(${hexToRgb(hex)},${alpha2})`);
    return grad;
}

const sharedOptions = (extraTooltip={}) => ({
    responsive: true, maintainAspectRatio: false, interaction: { mode: 'index', intersect: false },
    plugins: { legend: { display: false }, tooltip: { backgroundColor: 'rgba(13,15,26,0.90)', padding: 12, cornerRadius: 10, ...extraTooltip } },
    scales: { x: { grid: { display: false }, border: { display: false } }, y: { beginAtZero: true, grid: { color: 'rgba(208,213,232,0.35)' }, border: { display: false } } }
});

// SVG Chart Function
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

function renderFiturChart() {
    const wrap = document.getElementById('chart-fitur');
    const legend = document.getElementById('fitur-legend');
    if (!wrap) return;
    const max = fiturData[0].usage;
    const totalUsage = fiturData.reduce((s,d)=>s+d.usage,0);
    wrap.innerHTML = fiturData.map((d, i) => {
        const pctTotal = Math.round((d.usage/totalUsage)*100);
        return `<div class="fitur-row" style="animation-delay:${i*0.07}s">
            <div class="fitur-icon text-lg">${d.icon}</div>
            <div class="fitur-info">
                <div class="fitur-name">${d.name}</div>
                <div class="fitur-bar-track"><div class="fitur-bar-fill" id="fbar-${i}" style="background:linear-gradient(90deg,${d.color},${d.color}aa);width:0"></div></div>
            </div>
            <div class="fitur-pct" style="color:${d.color}">${pctTotal}%</div>
        </div>`;
    }).join('');

    if (legend) {
        legend.innerHTML = fiturData.map(d => `<div class="fitur-legend-item"><div class="fitur-legend-dot" style="background:${d.color}"></div>${d.name.split(' ')[0]}</div>`).join('');
    }

    fiturData.forEach((d, i) => {
        const bar = document.getElementById('fbar-'+i);
        if (bar) setTimeout(() => { bar.style.width = Math.round((d.usage/max)*100) + '%'; }, i * 100 + 250);
    });
}

document.addEventListener('DOMContentLoaded', () => {
    // 1. Line SVG User Registration
    renderLineChartSVG('chart-user-reg', userRegData, '#8b5cf6');

    // 2. Fitur List Chart
    renderFiturChart();

    // 3. Chart.js init
    const cv = document.getElementById('chartViewHarian');
    if(cv) chartAViewH = new Chart(cv, { type: 'line', data: { labels: analitikViewHarian.labels, datasets: [{ label: 'Views', data: analitikViewHarian.data, borderColor: '#0ea5e9', borderWidth: 2.5, backgroundColor: buildGradient(cv, '#0ea5e9'), pointBackgroundColor: '#0ea5e9', pointBorderColor: '#fff', pointRadius: 4, tension: 0.42, fill: true }] }, options: sharedOptions({ callbacks: { label: ctx => `  Views: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const cr = document.getElementById('chartRisetKlik');
    if(cr) chartARiset = new Chart(cr, { type: 'bar', data: { labels: risetKlikData.shortLabels, datasets: [{ label: 'Klik', data: risetKlikData.data, backgroundColor: ['rgba(139,92,246,0.85)','rgba(139,92,246,0.75)','rgba(139,92,246,0.65)','rgba(139,92,246,0.58)','rgba(139,92,246,0.50)','rgba(139,92,246,0.43)'], borderColor: '#8b5cf6', borderWidth: 1.5, borderRadius: 8 }] }, options: sharedOptions({ callbacks: { title: i => risetKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });

    const ce = document.getElementById('chartEventKlik');
    if(ce) chartAEvent = new Chart(ce, { type: 'bar', data: { labels: eventKlikData.shortLabels, datasets: [{ label: 'Klik', data: eventKlikData.data, backgroundColor: ['rgba(245,158,11,0.88)','rgba(245,158,11,0.76)','rgba(245,158,11,0.66)','rgba(245,158,11,0.58)','rgba(245,158,11,0.50)','rgba(245,158,11,0.43)'], borderColor: '#f59e0b', borderWidth: 1.5, borderRadius: 8 }] }, options: sharedOptions({ callbacks: { title: i => eventKlikData.labels[i[0].dataIndex], label: ctx => `  Klik: ${ctx.parsed.y.toLocaleString('id-ID')}` } }) });
});

function toggleViewChart(mode) {
    analitikViewMode = mode;
    const btnH = document.getElementById('vbtn-harian'), btnM = document.getElementById('vbtn-mingguan');
    if (mode === 'harian') {
        btnH && (btnH.style.borderColor='var(--blue)', btnH.style.color='var(--blue)'); btnM && (btnM.style.borderColor='', btnM.style.color='');
        document.getElementById('vstat-total').textContent='1.942'; document.getElementById('vstat-avg').textContent='277'; document.getElementById('vstat-peak').textContent='412';
    } else {
        btnM && (btnM.style.borderColor='var(--blue)', btnM.style.color='var(--blue)'); btnH && (btnH.style.borderColor='', btnH.style.color='');
        document.getElementById('vstat-total').textContent='7.348'; document.getElementById('vstat-avg').textContent='1.837'; document.getElementById('vstat-peak').textContent='2.214';
    }
    if (chartAViewH) {
        const d = mode === 'harian' ? analitikViewHarian : analitikViewMingguan;
        chartAViewH.data.labels = d.labels; chartAViewH.data.datasets[0].data = d.data; chartAViewH.update();
    }
}
</script>
@endpush