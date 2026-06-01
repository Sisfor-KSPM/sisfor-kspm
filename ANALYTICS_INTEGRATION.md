# Panduan Integrasi Analytics Tracking

## Overview

Sistem analytics tracking otomatis mencatat setiap aktivitas user untuk dashboard analytics. Implementasi sangat sederhana dan bisa dilakukan di berbagai tempat (Frontend, Backend, atau keduanya).

---

## 🚀 Quick Start

### 1. Track Feature Usage (Kalkulator, Kamus, dll)

**Dari Frontend (JavaScript):**

```javascript
// Include di dalam view
<script src="{{ asset('js/analytics-tracker.js') }}"></script>;

// Ketika user klik tombol kalkulator
document
    .getElementById("kalkulator-btn")
    .addEventListener("click", function () {
        AnalyticsTracker.trackFeature("kalkulator");
    });

// Ketika user membuka halaman kamus
document.addEventListener("DOMContentLoaded", function () {
    AnalyticsTracker.trackPage("kamus");
});
```

**Dari Backend (Controller):**

```php
use App\Services\AnalyticsService;

public function accessCalculator()
{
    // ... logic kalkulator
    AnalyticsService::trackFeatureUsage('kalkulator');
}
```

---

### 2. Track Event Interactions (Kegiatan/Events)

**Dari Frontend:**

```javascript
// Ketika user klik event atau hover
document.querySelector(".event-card").addEventListener("click", function () {
    AnalyticsTracker.trackEvent(eventId, "click");
});

// Ketika user tandai sebagai interested
document
    .getElementById("interested-btn")
    .addEventListener("click", function () {
        AnalyticsTracker.trackEvent(eventId, "interested");
    });
```

**Dari Backend:**

```php
public function viewEvent($eventId)
{
    AnalyticsService::trackEventInteraction($eventId, 'view');
}

public function attendEvent($eventId)
{
    AnalyticsService::trackEventInteraction($eventId, 'attend');
}
```

---

### 3. Track Report Downloads (Riset/Download)

**Dari Frontend:**

```javascript
// Ketika user klik tombol download
document.getElementById("download-btn").addEventListener("click", function () {
    AnalyticsTracker.trackDownload(reportId, "Riset Terbaru");
    // Kemudian trigger download
    window.location.href = downloadUrl;
});
```

**Dari Backend:**

```php
public function downloadReport($reportId)
{
    $report = Report::find($reportId);
    AnalyticsService::trackReportDownload($reportId, $report->title);

    return response()->download($report->file_path);
}
```

---

### 4. Track Page Views (Otomatis)

Middleware `TrackPageView` sudah track setiap akses page otomatis. Jika diperlukan track manual:

```javascript
// Di load awal page
document.addEventListener("DOMContentLoaded", function () {
    AnalyticsTracker.trackPage("home");
    AnalyticsTracker.trackPage("events");
});
```

---

## 📊 API Endpoints

### POST `/api/analytics/track-feature`

Track penggunaan fitur

```json
{
    "feature_name": "kalkulator"
}
```

### POST `/api/analytics/track-event`

Track interaksi event

```json
{
    "event_id": 1,
    "interaction_type": "click"
}
```

**Tipe interaksi:** `view`, `click`, `attend`, `interested`

### POST `/api/analytics/track-download`

Track unduhan

```json
{
    "report_id": 1,
    "report_title": "Laporan Kuartalan"
}
```

### POST `/api/analytics/track-page`

Track akses page

```json
{
    "page_name": "kamus"
}
```

---

## 🔧 Implementasi di Controllers

### HomeContentController - Track akses fitur

```php
use App\Services\AnalyticsService;

public function eLibrary()
{
    AnalyticsService::trackFeatureUsage('elibrary');
    return view('elibrary');
}

public function kalkulator()
{
    AnalyticsService::trackFeatureUsage('kalkulator');
    return view('user.kalkulator');
}
```

### EventController - Track event interactions

```php
public function showEvent($eventId)
{
    AnalyticsService::trackEventInteraction($eventId, 'view');
    $event = Event::find($eventId);
    return view('events.show', compact('event'));
}
```

### ReportController - Track downloads

```php
public function download($reportId)
{
    $report = Report::find($reportId);
    AnalyticsService::trackReportDownload($reportId, $report->title);

    return response()->download(
        storage_path('app/' . $report->file_path),
        $report->title . '.pdf'
    );
}
```

---

## 📈 Query Data Analytics

### Fitur yang paling sering digunakan

```php
$features = AnalyticsService::getMostUsedFeatures(10, 30);
// Returns: [
//   {feature_name: "kalkulator", total_uses: 150, unique_users: 45},
//   {feature_name: "kamus", total_uses: 120, unique_users: 38},
// ]
```

### Event yang paling banyak diklik

```php
$events = AnalyticsService::getMostInteractedEvents(10, 30);
// Returns: [
//   {event_id: 1, interaction_count: 89, unique_users: 23},
//   {event_id: 2, interaction_count: 56, unique_users: 15},
// ]
```

### Riset yang paling sering didownload

```php
$reports = AnalyticsService::getMostDownloadedReports(10);
// Returns: [
//   {report_id: 1, download_count: 45, ...},
//   {report_id: 2, download_count: 32, ...},
// ]
```

### Pertumbuhan user registrasi

```php
$growth = AnalyticsService::getUserGrowth(30);
// Returns: [
//   {date: "2026-05-01", count: 5},
//   {date: "2026-05-02", count: 8},
// ]
```

### Statistik General

```php
$stats = AnalyticsService::getGeneralStats(30);
// Returns: [
//   'total_users' => 500,
//   'new_users' => 45,
//   'total_feature_usage' => 1200,
//   'total_event_interactions' => 340,
//   'total_report_downloads' => 125,
//   'unique_active_users' => 180,
// ]
```

---

## 🛠️ Contoh Implementasi di Blade Template

```blade
<!-- Dalam view -->
@push('scripts')
<script src="{{ asset('js/analytics-tracker.js') }}"></script>
@endpush

<!-- Button dengan tracking -->
<button onclick="AnalyticsTracker.trackFeature('kalkulator'); goToCalculator();">
    Buka Kalkulator
</button>

<!-- Event card dengan tracking -->
@foreach($events as $event)
    <div class="event-card" onclick="AnalyticsTracker.trackEvent({{ $event->id }}, 'click');">
        {{ $event->title }}
    </div>
@endforeach

<!-- Download button dengan tracking -->
<a href="{{ route('download.report', $report->id) }}"
   onclick="AnalyticsTracker.trackDownload({{ $report->id }}, '{{ $report->title }}');">
    Download Report
</a>
```

---

## 📋 Checklist Integrasi

- [ ] Include `analytics-tracker.js` di layout/base template
- [ ] Tambah tracking di fitur Kalkulator
- [ ] Tambah tracking di fitur Kamus
- [ ] Tambah tracking di Event views
- [ ] Tambah tracking di Report download
- [ ] Tambah tracking di Gallery views
- [ ] Tambah tracking di E-Library
- [ ] Test semua tracking di admin dashboard analytics
- [ ] Verifikasi data muncul di database

---

## 🔐 Security Notes

- API endpoints `/api/analytics/*` tidak memerlukan auth (anonymous tracking)
- Jika user login, `user_id` akan tercatat otomatis
- IP address dan User Agent dicatat untuk setiap aktivitas
- CSRF token diperlukan dari form/AJAX request

---

## 💡 Tips Maintenance

1. **Cleanup old data** - Jalankan scheduled job untuk hapus analytics lama (> 6 bulan)
2. **Index columns** - Pastikan `user_id`, `feature_name`, `created_at` sudah di-index
3. **Monitor performance** - Tracking tidak sync, gunakan queue jika traffic tinggi

---

Implementasi selesai! Gunakan panduan ini untuk integrate tracking di semua fitur.
