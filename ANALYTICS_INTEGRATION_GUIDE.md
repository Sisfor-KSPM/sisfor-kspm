# Panduan Integrasi Analytics Tracking

## 1. Modal Opens (Event & User Events)

### Untuk View Events
**File**: `resources/views/event.blade.php` atau controller `EventController`

```php
// Di controller atau via AJAX
AnalyticsService::trackModalOpen('event_detail', $eventId);
```

**JavaScript untuk AJAX**:
```javascript
// Ketika modal dibuka
function openEventModal(eventId) {
    fetch('/api/analytics/track-modal', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            modal_type: 'event_detail',
            target_id: eventId
        })
    });
    // ... kode modal opening lainnya
}
```

### Untuk User Events
```php
AnalyticsService::trackModalOpen('user_event_detail', $eventId);
```

---

## 2. Downloads (Elibrary & User Riset)

### Untuk Riset/Report Downloads
```php
// Di controller atau sebelum download file
AnalyticsService::trackDocumentDownload('riset', $reportId, $reportTitle);
```

**Contoh di controller**:
```php
public function downloadReport($reportId)
{
    $report = Report::find($reportId);
    
    // Track download
    AnalyticsService::trackDocumentDownload('riset', $reportId, $report->title);
    
    // Actual file download logic
    return response()->download($report->file_path);
}
```

### Untuk Elibrary Downloads
```php
AnalyticsService::trackDocumentDownload('elibrary', $documentId, $documentName);
```

---

## 3. Kamus/Dictionary Access

### Untuk View Elibrary Kamus
```php
// Di controller atau view
AnalyticsService::trackDictionaryAccess($dictionaryId, $wordName);
```

**Contoh di controller**:
```php
public function showDictionary($id)
{
    $entry = Dictionary::find($id);
    
    // Track access
    AnalyticsService::trackDictionaryAccess($id, $entry->word);
    
    return view('elibrary.kamus.show', ['entry' => $entry]);
}
```

### Untuk User Kamus
```php
// Sama seperti elibrary, tapi di user routes/controller
AnalyticsService::trackDictionaryAccess($dictionaryId, $wordName);
```

---

## 4. Calculator Actions (User Kalkulator)

### Untuk Berbagai Tombol Hitung

**JavaScript (di view user.kalkulator)**:
```javascript
// Hitung Rata-rata
document.getElementById('btn-calculate-average').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('[name="csrf-token"]').content,
        },
        body: JSON.stringify({
            action: 'calculate_average'
        })
    }).then(r => r.json()).catch(e => console.log(e));
    // ... kode hitung rata-rata
});

// Hitung Profit/Loss
document.getElementById('btn-calculate-pl').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        body: JSON.stringify({ action: 'calculate_profit_loss' })
    });
    // ... kode hitung P/L
});

// Hitung BEP
document.getElementById('btn-calculate-bep').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        body: JSON.stringify({ action: 'calculate_bep' })
    });
    // ... kode hitung BEP
});

// Kalkulasi Total Fee
document.getElementById('btn-calculate-fee').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        body: JSON.stringify({ action: 'calculate_total_fee' })
    });
    // ... kode kalkulasi fee
});

// Hitung Dividen Neto
document.getElementById('btn-calculate-dividend').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        body: JSON.stringify({ action: 'calculate_dividend_neto' })
    });
    // ... kode hitung dividen
});

// Hitung Valuasi
document.getElementById('btn-calculate-valuation').addEventListener('click', function() {
    fetch('/api/analytics/track-calculator', {
        method: 'POST',
        body: JSON.stringify({ action: 'calculate_valuation' })
    });
    // ... kode hitung valuasi
});
```

---

## 5. API Route untuk AJAX Tracking

**Tambahkan di `routes/api.php`**:
```php
Route::middleware(['auth'])->group(function () {
    Route::post('/analytics/track-modal', function (Request $request) {
        AnalyticsService::trackModalOpen(
            $request->input('modal_type'),
            $request->input('target_id')
        );
        return response()->json(['success' => true]);
    });

    Route::post('/analytics/track-calculator', function (Request $request) {
        AnalyticsService::trackCalculatorAction($request->input('action'));
        return response()->json(['success' => true]);
    });

    Route::post('/analytics/track-download', function (Request $request) {
        AnalyticsService::trackDocumentDownload(
            $request->input('type'),
            $request->input('id'),
            $request->input('name')
        );
        return response()->json(['success' => true]);
    });

    Route::post('/analytics/track-dictionary', function (Request $request) {
        AnalyticsService::trackDictionaryAccess(
            $request->input('id'),
            $request->input('name')
        );
        return response()->json(['success' => true]);
    });
});
```

---

## 6. Viewing Analytics Data

### Dashboard Controller Example
```php
<?php

namespace App\Http\Controllers;

use App\Services\AnalyticsService;

class DashboardController extends Controller
{
    public function analytics()
    {
        $stats = AnalyticsService::getGeneralStats(30); // Last 30 days
        $topEvents = AnalyticsService::getMostInteractedEvents(10);
        $topReports = AnalyticsService::getMostDownloadedReports(10);
        $userStats = AnalyticsService::getUserInteractionStats(auth()->id(), 30);

        return view('dashboard.analytics', [
            'stats' => $stats,
            'topEvents' => $topEvents,
            'topReports' => $topReports,
            'userStats' => $userStats,
        ]);
    }
}
```

### Blade View Example
```blade
<div class="analytics-dashboard">
    <h2>Statistik Umum (30 hari terakhir)</h2>
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Total Users</h3>
            <p>{{ $stats['total_users'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Event Interactions</h3>
            <p>{{ $stats['total_event_interactions'] }}</p>
        </div>
        <div class="stat-card">
            <h3>Feature Usage</h3>
            <p>{{ $stats['total_feature_usage'] }}</p>
        </div>
    </div>

    <h2>Top Events (Most Interacted)</h2>
    <table>
        <thead>
            <tr>
                <th>Event ID</th>
                <th>Interactions</th>
                <th>Unique Users</th>
            </tr>
        </thead>
        <tbody>
            @foreach($topEvents as $event)
            <tr>
                <td>{{ $event->event_id }}</td>
                <td>{{ $event->interaction_count }}</td>
                <td>{{ $event->unique_users }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>My Activity Stats</h2>
    <ul>
        <li>Features Used: {{ $userStats['feature_uses'] }} times</li>
        <li>Event Interactions: {{ $userStats['event_interactions'] }} times</li>
        <li>Downloads: {{ $userStats['downloads'] }} files</li>
        <li>Activities: {{ $userStats['activities'] }} actions</li>
    </ul>
</div>
```

---

## Checklist Implementasi

- [ ] Tambahkan AJAX route di `routes/api.php`
- [ ] Integrasikan tracking di event modals
- [ ] Integrasikan tracking di download buttons (riset, elibrary)
- [ ] Integrasikan tracking di dictionary access (kamus)
- [ ] Integrasikan tracking di calculator buttons (kalkulator)
- [ ] Test semua tracking di browser console
- [ ] Verifikasi data masuk ke database
- [ ] Buat analytics dashboard untuk melihat data

---

## Troubleshooting

### Data tidak masuk
- Pastikan user authenticated (`Auth::check()`)
- Cek CSRF token valid
- Lihat `storage/logs/laravel.log` untuk error

### Slow queries
- Pastikan sudah ada index di `event_interactions` table
- Query sudah di-optimize dengan `.toDateTimeString()`

---

**Updated**: June 2, 2026
**Version**: 1.0
