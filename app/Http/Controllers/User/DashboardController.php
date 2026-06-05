<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Event;
use App\Models\EventInteraction;
use App\Models\Report;
use App\Models\ReportDownload;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAnggota = User::where('role', 'user')->count();
        $anggotaBulanIni = User::where('role', 'user')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        $kegiatanAktif = Event::where('tipe', 'kegiatan')
            ->whereIn('status', ['berlangsung', 'upcoming'])
            ->count();

        $upcomingKegiatan = Event::where('tipe', 'kegiatan')
            ->where('status', 'upcoming')
            ->count();

        $infoLomba = Event::where('tipe', 'lomba')
            ->whereIn('status', ['berlangsung', 'upcoming'])
            ->count();

        $totalRiset = Report::where('status', 'publik')->count();
        $risetMingguIni = Report::where('status', 'publik')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(5)
            ->get();

        $memberChartData = collect(range(5, 0))->map(function ($monthsAgo) {
            $month = now()->subMonths($monthsAgo);

            return [
                'm' => $month->translatedFormat('M'),
                'v' => User::where('role', 'user')
                    ->whereMonth('created_at', $month->month)
                    ->whereYear('created_at', $month->year)
                    ->count(),
            ];
        })->values();

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
        })->values();

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
        })->values();

        $risetKlikData = ReportDownload::selectRaw('report_title as title, SUM(download_count) as views')
            ->groupBy('report_id', 'report_title')
            ->orderByDesc('views')
            ->take(6)
            ->get();

        if ($risetKlikData->isEmpty()) {
            $risetKlikData = Report::where('status', 'publik')
                ->latest()
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

        $chartData = [
            'visitorHarian' => $visitorHarian,
            'visitorMingguan' => $visitorMingguan,
            'visitorAvg' => (int) round($visitorHarian->avg('value') ?? 0),
            'visitorPeak' => (int) ($visitorHarian->max('value') ?? 0),
            'visitorTotal' => (int) $visitorHarian->sum('value'),
            'weeklyTotal' => (int) $visitorMingguan->sum('value'),
            'weeklyPeak' => (int) ($visitorMingguan->max('value') ?? 0),
            'risetKlikData' => $risetKlikData,
            'eventKlikData' => $eventKlikData,
            'topRisetTitle' => optional($risetKlikData->sortByDesc('views')->first())->title ?? '-',
            'topEventTitle' => optional($eventKlikData->sortByDesc('views')->first())->title ?? '-',
        ];

        $memberAverageGrowth = (int) round($memberChartData->avg('v') ?? 0);
        $activeMemberPercentage = $totalAnggota > 0
            ? (int) round(User::where('role', 'user')->whereNotNull('email_verified_at')->count() / $totalAnggota * 100)
            : 0;

        return view('user.dashboard', compact(
            'totalAnggota',
            'anggotaBulanIni',
            'kegiatanAktif',
            'upcomingKegiatan',
            'infoLomba',
            'totalRiset',
            'risetMingguIni',
            'recentActivities',
            'memberChartData',
            'chartData',
            'memberAverageGrowth',
            'activeMemberPercentage'
        ));
    }
}
