{{-- 
  Contoh Implementasi Analytics Tracking di Blade Templates
  Copy-paste snippets ini ke view Anda untuk track aktivitas user
--}}

{{-- 1. BASIC SETUP - Include ini di layout/base template --}}

@push('scripts')
<script src="{{ asset('js/analytics-tracker.js') }}"></script>
<script>
    // Optional: Enable auto-tracking untuk link tertentu
    document.addEventListener('DOMContentLoaded', function() {
        // Track page pada load
        AnalyticsTracker.trackPage('{{ request()->route()?->getName() ?? 'unknown' }}');
    });
</script>
@endpush


{{-- 2. TRACK FITUR USAGE - Kalkulator, Kamus, Gallery, etc --}}

<!-- Button Track Feature -->
<button class="btn btn-primary" onclick="trackAndGo('kalkulator', '/user/kalkulator')">
    📊 Buka Kalkulator
</button>

<a href="/kamus" onclick="trackAndGo('kamus', '/kamus')">Kamus Saham</a>

<script>
function trackAndGo(featureName, url) {
    AnalyticsTracker.trackFeature(featureName);
    window.location.href = url;
}
</script>


{{-- 3. TRACK EVENT INTERACTIONS - Events, Kegiatan --}}

@forelse($events as $event)
    <div class="event-card" style="cursor: pointer;">
        <div class="event-header" onclick="handleEventClick({{ $event->id }})">
            <h3>{{ $event->title }}</h3>
            <p>{{ $event->description }}</p>
        </div>
        
        <!-- Tombol Interested -->
        <button class="btn btn-sm" onclick="markInterested({{ $event->id }})">
            ⭐ Tertarik
        </button>
    </div>
@empty
    <p>Tidak ada event saat ini</p>
@endforelse

<script>
function handleEventClick(eventId) {
    AnalyticsTracker.trackEvent(eventId, 'click');
    // Lalu arahkan atau buka modal
}

function markInterested(eventId) {
    AnalyticsTracker.trackEvent(eventId, 'interested');
    // Lalu simpan ke database
}
</script>


{{-- 4. TRACK REPORT DOWNLOADS - E-Library, Riset --}}

@forelse($reports as $report)
    <div class="report-item">
        <h4>{{ $report->title }}</h4>
        <p>{{ $report->description }}</p>
        
        <!-- Download Button -->
        <a href="{{ route('download.report', $report->id) }}" 
           class="btn btn-download"
           onclick="handleDownload({{ $report->id }}, '{{ $report->title }}', event)">
            📥 Download PDF
        </a>
    </div>
@empty
    <p>Tidak ada riset tersedia</p>
@endforelse

<script>
function handleDownload(reportId, reportTitle, event) {
    // Track dulu sebelum download
    AnalyticsTracker.trackDownload(reportId, reportTitle);
    
    // Biarkan link download normal jalan
    // (atau gunakan fetch API untuk kontrol lebih)
}
</script>


{{-- 5. TRACK GALLERY VIEWS --}}

@forelse($galleries as $gallery)
    <div class="gallery-item" onclick="viewGallery({{ $gallery->id }})">
        <img src="{{ $gallery->image }}" alt="{{ $gallery->title }}">
        <p>{{ $gallery->title }}</p>
    </div>
@empty
    <p>Gallery kosong</p>
@endforelse

<script>
function viewGallery(galleryId) {
    AnalyticsTracker.trackFeature('gallery_view_' + galleryId);
    // Buka lightbox atau modal
}
</script>


{{-- 6. TRACK KAMUS/DICTIONARY SEARCH --}}

<input type="text" id="dictionary-search" placeholder="Cari istilah...">

<script>
let searchTimeout;
document.getElementById('dictionary-search').addEventListener('keyup', function(e) {
    clearTimeout(searchTimeout);
    
    searchTimeout = setTimeout(function() {
        if (e.target.value.length > 2) {
            AnalyticsTracker.trackFeature('kamus_search_' + e.target.value);
            // Lalu lakukan search
        }
    }, 500);
});
</script>


{{-- 7. TRACK FORM SUBMISSIONS --}}

<form id="contact-form" onsubmit="handleFormSubmit(event, 'contact')">
    <input type="text" name="name" placeholder="Nama">
    <input type="email" name="email" placeholder="Email">
    <textarea name="message" placeholder="Pesan"></textarea>
    <button type="submit">Kirim</button>
</form>

<script>
function handleFormSubmit(event, formName) {
    AnalyticsTracker.trackFeature(formName + '_submit');
    // Lanjutkan submit form
}
</script>


{{-- 8. TRACK MODAL/POPUP OPENS --}}

<button onclick="openModal('calculator-modal', 'kalkulator')">
    Buka Modal Kalkulator
</button>

<script>
function openModal(modalId, featureName) {
    AnalyticsTracker.trackFeature(featureName + '_modal_open');
    document.getElementById(modalId).style.display = 'block';
}
</script>


{{-- 9. TRACK NAVIGATION --}}

<nav class="navbar">
    <a href="/kamus" onclick="trackNav(event, 'kamus')">Kamus</a>
    <a href="/events" onclick="trackNav(event, 'events')">Events</a>
    <a href="/gallery" onclick="trackNav(event, 'gallery')">Galeri</a>
    <a href="/elibrary" onclick="trackNav(event, 'elibrary')">E-Library</a>
</nav>

<script>
function trackNav(event, pageName) {
    AnalyticsTracker.trackPage(pageName);
}
</script>


{{-- 10. TRACK SCROLL DEPTH (untuk long pages) --}}

<script>
let maxScroll = 0;

window.addEventListener('scroll', function() {
    const scrollPercent = (window.scrollY / (document.documentElement.scrollHeight - window.innerHeight)) * 100;
    
    if (scrollPercent > 25 && maxScroll <= 25) {
        maxScroll = 25;
        AnalyticsTracker.trackFeature('scroll_25_percent');
    }
    if (scrollPercent > 50 && maxScroll <= 50) {
        maxScroll = 50;
        AnalyticsTracker.trackFeature('scroll_50_percent');
    }
    if (scrollPercent > 75 && maxScroll <= 75) {
        maxScroll = 75;
        AnalyticsTracker.trackFeature('scroll_75_percent');
    }
});
</script>


{{-- 11. BACKEND TRACKING - Di Controller (Laravel) --}}

{{-- File: app/Http/Controllers/ReportController.php --}}
<?php

public function downloadReport($reportId)
{
    $report = Report::find($reportId);
    
    // Track sebelum download
    AnalyticsService::trackReportDownload($reportId, $report->title);
    
    return response()->download($report->file_path);
}

public function viewReport($reportId)
{
    $report = Report::find($reportId);
    
    // Track akses report
    AnalyticsService::trackFeatureUsage('report_view_' . $reportId);
    
    return view('report.show', compact('report'));
}
?>


{{-- 12. BLADE HELPER USAGE (Jika sudah register helper di composer) --}}

<script>
    // Langsung gunakan shorthand function
    @php
        track_feature('page_load');
    @endphp
    
    // Di JavaScript
    // Tidak perlu, gunakan AnalyticsTracker.trackFeature() dari JS
</script>

{{-- Atau gunakan di PHP section: --}}

@php
    // Track dari controller/view
    track_feature('view_render');
    $stats = analytics_stats();
@endphp

<!-- Display stats jika perlu -->
<div class="stats">
    <p>Total Users: {{ $stats['total_users'] ?? 0 }}</p>
    <p>New Users: {{ $stats['new_users'] ?? 0 }}</p>
    <p>Total Feature Usage: {{ $stats['total_feature_usage'] ?? 0 }}</p>
</div>
