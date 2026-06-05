<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;
use App\Models\Event;
use App\Models\Report;
use App\Models\ActivityLog;
use App\Models\EventInteraction;
use App\Models\ReportDownload;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $memberRoles = ['ipb', 'umum'];

        // 1. STAT CARDS: Menghitung Total Anggota (Role: user)
        $totalAnggota = User::whereIn('role', $memberRoles)->count();
        $anggotaBulanIni = User::whereIn('role', $memberRoles)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // 2. STAT CARDS: Menghitung Kegiatan Aktif & Info Lomba
        $kegiatanAktif = Event::where('tipe', 'kegiatan')
                              ->whereIn('status', ['berlangsung', 'upcoming'])
                              ->count();
                              
        $upcomingKegiatan = Event::where('tipe', 'kegiatan')
                                 ->where('status', 'upcoming')
                                 ->count();
        
        $infoLomba = Event::where('tipe', 'lomba')
                          ->whereIn('status', ['berlangsung', 'upcoming'])
                          ->count();

        // 3. STAT CARDS: Menghitung Publikasi Riset
        $totalRiset = Report::count();
        $risetMingguIni = Report::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // 4. Aktivitas Terbaru (Ambil 5 aktivitas paling baru)
        $recentActivities = ActivityLog::with('user')->latest()->take(5)->get();

        // 5. Grafik: Pertumbuhan Anggota (6 bulan terakhir)
        $memberChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereIn('role', $memberRoles)
                         ->whereMonth('created_at', $month->month)
                         ->whereYear('created_at', $month->year)
                         ->count();
                         
            $memberChartData[] = [
                'm' => $month->translatedFormat('M'), 
                'v' => $count
            ];
        }

        // 6. Data grafik pengunjung dari activity_logs.
        $visitorHarian = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $date->translatedFormat('D'),
                'value' => ActivityLog::whereDate('created_at', $date)
                    ->where(function ($query) {
                        $query->where('action', 'view')
                            ->orWhere('activity_type', 'page_view');
                    })
                    ->count(),
            ];
        });

        $visitorMingguan = collect(range(3, 0))->map(function ($weeksAgo) {
            $start = Carbon::now()->startOfWeek()->subWeeks($weeksAgo);
            $end = (clone $start)->endOfWeek();

            return [
                'label' => 'Minggu ' . (4 - $weeksAgo),
                'value' => ActivityLog::whereBetween('created_at', [$start, $end])
                    ->where(function ($query) {
                        $query->where('action', 'view')
                            ->orWhere('activity_type', 'page_view');
                    })
                    ->count(),
            ];
        });

        $visitorAvg = (int) round($visitorHarian->avg('value') ?? 0);
        $visitorPeak = (int) ($visitorHarian->max('value') ?? 0);
        $visitorTotal = (int) $visitorHarian->sum('value');
        $weeklyTotal = (int) $visitorMingguan->sum('value');
        $weeklyPeak = (int) ($visitorMingguan->max('value') ?? 0);

        // 7. Data grafik riset dan event dari tabel tracking.
        $risetKlikData = ReportDownload::selectRaw('report_title as title, SUM(download_count) as views')
            ->groupBy('report_id', 'report_title')
            ->orderByDesc('views')
            ->take(6)
            ->get();

        if ($risetKlikData->isEmpty()) {
            $risetKlikData = Report::latest()
                ->take(6)
                ->get(['judul_riset'])
                ->map(fn ($report) => (object) [
                    'title' => $report->judul_riset,
                    'views' => 0,
                ]);
        }

        $eventKlikData = EventInteraction::join('events', 'event_interactions.event_id', '=', 'events.id')
            ->selectRaw('events.kegiatan as title, COUNT(*) as views')
            ->groupBy('events.id', 'events.kegiatan')
            ->orderByDesc('views')
            ->take(6)
            ->get();

        if ($eventKlikData->isEmpty()) {
            $eventKlikData = Event::latest()
                ->take(6)
                ->get(['kegiatan'])
                ->map(fn ($event) => (object) [
                    'title' => $event->kegiatan,
                    'views' => 0,
                ]);
        }

        $topRisetTitle = optional($risetKlikData->sortByDesc('views')->first())->title ?? '-';
        $topEventTitle = optional($eventKlikData->sortByDesc('views')->first())->title ?? '-';
        $memberAverageGrowth = (int) round(collect($memberChartData)->avg('v') ?? 0);
        $activeMemberPercentage = $totalAnggota > 0
            ? (int) round(User::whereIn('role', $memberRoles)->whereNotNull('email_verified_at')->count() / $totalAnggota * 100)
            : 0;

        $chartData = [
            'visitorHarian' => $visitorHarian,
            'visitorMingguan' => $visitorMingguan,
            'visitorAvg' => $visitorAvg,
            'visitorPeak' => $visitorPeak,
            'visitorTotal' => $visitorTotal,
            'weeklyTotal' => $weeklyTotal,
            'weeklyPeak' => $weeklyPeak,
            'risetKlikData' => $risetKlikData,
            'eventKlikData' => $eventKlikData,
            'topRisetTitle' => $topRisetTitle,
            'topEventTitle' => $topEventTitle,
        ];

        return view('admin.dashboard', compact(
            'totalAnggota', 'anggotaBulanIni',
            'kegiatanAktif', 'upcomingKegiatan',
            'infoLomba',
            'totalRiset', 'risetMingguIni',
            'recentActivities',
            'memberChartData',
            'chartData',
            'memberAverageGrowth',
            'activeMemberPercentage'
        ));
    }
}
