# 📊 Sistem Analytics Tracking Dinamis

Sistem analitik real-time yang track semua aktivitas user di website - dari fitur yang digunakan, events yang diklik, reports yang didownload, hingga pertumbuhan registrasi user.

## ✨ Features

- ✅ **Track Feature Usage** - Kalkulator, Kamus, Gallery, E-Library, Contact, dll
- ✅ **Track Event Interactions** - Klik event, tandai interested, attend, dll
- ✅ **Track Report Downloads** - Semua download riset tercatat
- ✅ **Track Page Views** - Akses halaman tercatat otomatis
- ✅ **User Growth Analytics** - Pertumbuhan registrasi user
- ✅ **Dashboard Analytics** - Visualisasi data analytics real-time
- ✅ **Auto Tracking** - Mudah integrate, tinggal add data attributes

## 🏗️ Architecture

```
Analytics System
├── Frontend (JavaScript)
│   ├── analytics-tracker.js (Core tracking)
│   └── auto-analytics-tracker.js (Auto-tracking dengan data attributes)
├── API Endpoints (/api/analytics/*)
│   ├── POST /track-feature
│   ├── POST /track-event
│   ├── POST /track-download
│   └── POST /track-page
├── Backend Service
│   ├── AnalyticsService (Core service)
│   └── AnalyticsHelper (Helper functions)
├── Controllers
│   ├── AnalyticsTrackingController (API handlers)
│   └── AnalyticsController (Dashboard)
├── Middleware
│   └── TrackPageView (Auto track page access)
└── Database Models
    ├── FeatureUsage (track fitur)
    ├── EventInteraction (track event interactions)
    ├── ReportDownload (track downloads)
    └── ActivityLog (general activity log)
```

## 🚀 Quick Start

### 1. Setup (Already Done)
- Service, Controllers, Routes, dan Models sudah dibuat
- Middleware sudah diregister

### 2. Include JavaScript di Base Layout

```blade
<!-- Di resources/views/layouts/app.blade.php atau base template -->
@push('scripts')
    <script src="{{ asset('js/analytics-tracker.js') }}"></script>
    <script src="{{ asset('js/auto-analytics-tracker.js') }}"></script>
@endpush
```

### 3. Integrate dengan HTML (3 Cara)

#### **CARA 1: Otomatis dengan Data Attributes (Rekomendasi)**
Paling mudah, tinggal add `data-track-*` attributes:

```blade
<!-- Track Feature -->
<button data-track-feature="kalkulator">Buka Kalkulator</button>
<button data-track-feature="kamus">Buka Kamus</button>

<!-- Track Event -->
<div class="event-card" data-track-event="5" data-track-type="view">
    <h3>Event Title</h3>
    <button data-track-event="5" data-track-type="click">Lihat Detail</button>
</div>

<!-- Track Download -->
<a data-track-download="1" data-track-title="Laporan Q1" href="/download/1">
    Download Report
</a>

<!-- Track Page Navigation -->
<a href="/kamus" data-track-page="kamus">Kamus Saham</a>
```

#### **CARA 2: Manual JavaScript**
Untuk interaksi kompleks:

```javascript
// Track feature
AnalyticsTracker.trackFeature('kalkulator');

// Track event
AnalyticsTracker.trackEvent(eventId, 'click');

// Track download
AnalyticsTracker.trackDownload(reportId, 'Laporan Q1');

// Track page
AnalyticsTracker.trackPage('kamus');
```

#### **CARA 3: Backend Tracking**
Dari controller:

```php
use App\Services\AnalyticsService;

public function kalkulator()
{
    AnalyticsService::trackFeatureUsage('kalkulator');
    return view('kalkulator');
}

public function downloadReport($reportId)
{
    $report = Report::find($reportId);
    AnalyticsService::trackReportDownload($reportId, $report->title);
    return response()->download($report->file_path);
}
```

Atau menggunakan helper:

```php
track_feature('kalkulator');
track_event($eventId, 'click');
track_download($reportId, 'Report Title');
```

## 📊 Data Analytics

### Database Tables

```sql
-- Feature Usage
- feature_usage (feature_name, user_id, usage_count, usage_date)

-- Event Interactions
- event_interactions (event_id, user_id, interaction_type, created_at)

-- Report Downloads
- report_downloads (report_id, user_id, report_title, download_count, last_download_date)

-- Activity Log
- activity_logs (user_id, activity_type, description, ip_address, user_agent, created_at)
```

### Get Analytics Data

```php
// Fitur paling sering digunakan
$features = AnalyticsService::getMostUsedFeatures(limit: 10, days: 30);

// Event paling banyak diklik
$events = AnalyticsService::getMostInteractedEvents(limit: 10, days: 30);

// Report paling sering didownload
$reports = AnalyticsService::getMostDownloadedReports(limit: 10);

// Pertumbuhan user registrasi
$growth = AnalyticsService::getUserGrowth(days: 30);

// Statistik general
$stats = AnalyticsService::getGeneralStats(days: 30);
// Returns:
// [
//     'total_users' => 500,
//     'new_users' => 45,
//     'total_feature_usage' => 1200,
//     'total_event_interactions' => 340,
//     'total_report_downloads' => 125,
//     'unique_active_users' => 180,
// ]
```

## 📍 Implementasi Per Fitur

### HomeController (Sudah Integrate)
✅ `kamus()` - Track feature 'kamus'
✅ `events()` - Track feature 'events'
✅ `gallery()` - Track feature 'gallery'
✅ `eLibrary()` - Track feature 'elibrary'
✅ `contact()` - Track feature 'contact'

### ReportController (TODO)
```php
// Tambahkan di method show/download
public function download($reportId)
{
    AnalyticsService::trackReportDownload($reportId, 'Report Title');
    // ... download logic
}
```

### EventController (TODO)
```php
// Tambahkan di method show
public function show($eventId)
{
    AnalyticsService::trackEventInteraction($eventId, 'view');
    // ... show logic
}
```

## 🔧 Implementasi Checklist

### Backend
- [x] AnalyticsService
- [x] AnalyticsTrackingController
- [x] TrackPageView Middleware
- [x] API Routes (/api/analytics/*)
- [x] AnalyticsHelper
- [ ] Update ReportController untuk track downloads
- [ ] Update EventController untuk track interactions
- [ ] Jalankan `composer dump-autoload`

### Frontend (Choose One)
- [ ] **Cara 1 (Auto)**: Include `auto-analytics-tracker.js` + add data attributes (Paling Mudah)
- [ ] **Cara 2 (Manual)**: Include `analytics-tracker.js` + manual JS calls
- [ ] **Cara 3 (Backend)**: Gunakan service/helper di controller

### Testing
- [ ] Visit http://localhost/admin/analitik
- [ ] Click various features
- [ ] Check database untuk verifikasi tracking
- [ ] Verify data muncul di dashboard

## 📈 Analytics Dashboard

View: `/admin/analitik`
Controller: `AnalyticsController`

Menampilkan:
- Fitur paling sering digunakan
- Event paling banyak diklik
- Report paling sering didownload
- Pertumbuhan user registrasi
- Statistik general

## 🛠️ API Endpoints

### Track Feature Usage
```bash
POST /api/analytics/track-feature
Content-Type: application/json

{
    "feature_name": "kalkulator"
}
```

### Track Event Interaction
```bash
POST /api/analytics/track-event
Content-Type: application/json

{
    "event_id": 1,
    "interaction_type": "click"
}
```

### Track Report Download
```bash
POST /api/analytics/track-download
Content-Type: application/json

{
    "report_id": 1,
    "report_title": "Laporan Terbaru"
}
```

### Track Page View
```bash
POST /api/analytics/track-page
Content-Type: application/json

{
    "page_name": "kamus"
}
```

## 🎯 Best Practices

### 1. Track pada Waktu Tepat
```javascript
// ❌ Salah: Track sebelum action selesai
AnalyticsTracker.trackFeature('download');
// ... belum download

// ✅ Benar: Track setelah/saat action
<a onclick="AnalyticsTracker.trackDownload(1); this.click()">Download</a>
```

### 2. Consistent Feature Names
```
Gunakan lowercase, underscore untuk separator:
✅ 'kalkulator', 'kamus', 'event_view', 'gallery_click'
❌ 'Kalkulator', 'Kamus', 'EventView', 'gallery click'
```

### 3. User Context
Kalau user tidak login, tetap bisa track (dengan user_id = null)
Tapi lebih baik track user yang login untuk analytics lebih akurat

### 4. Performance
Tracking adalah async (non-blocking), tidak mengganggu UX
Tapi jika traffic sangat tinggi, gunakan queue

## 🔐 Security

- Endpoint `/api/analytics/*` tidak require auth (untuk anonymous tracking)
- CSRF token diperlukan dari form/AJAX request
- IP address dan User Agent dicatat untuk audit
- Data sensitif tidak disimpan (hanya activity log)

## 📚 File Reference

| File | Purpose |
|------|---------|
| `app/Services/AnalyticsService.php` | Core analytics logic |
| `app/Http/Controllers/Api/AnalyticsTrackingController.php` | API handlers |
| `app/Http/Controllers/Admin/AnalyticsController.php` | Dashboard |
| `app/Http/Middleware/TrackPageView.php` | Auto page tracking |
| `app/Helpers/AnalyticsHelper.php` | Helper functions |
| `resources/js/analytics-tracker.js` | Frontend core JS |
| `resources/js/auto-analytics-tracker.js` | Frontend auto-tracking |
| `routes/api.php` | API routes |
| `routes/web.php` | Web routes (dashboard) |
| `ANALYTICS_INTEGRATION.md` | Detailed integration guide |

## 🚨 Troubleshooting

### Data tidak tercatat
1. Verifikasi CSRF token di form/AJAX
2. Check browser console untuk errors
3. Verifikasi user sudah login (kalau diperlukan)
4. Check database tables untuk melihat data

### Migration fails
```bash
php artisan migrate:fresh --seed
```

### Need to reload helper?
```bash
composer dump-autoload
```

## 📞 Next Steps

1. ✅ Implementasi selesai, tinggal integrate di views
2. Include script di layout
3. Add data attributes atau manual tracking calls
4. Test di admin analytics dashboard
5. Monitor performance

Selamat! Sistem analytics sudah siap digunakan 🎉
