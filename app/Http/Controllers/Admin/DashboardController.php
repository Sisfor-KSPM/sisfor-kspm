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

        // 1. STAT CARDS: Menghitung Total Anggota
        $totalAnggota = User::whereIn('role', $memberRoles)->count();
        $anggotaBulanIni = User::whereIn('role', $memberRoles)
                            ->whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->count();

        // 2. STAT CARDS: Menghitung Kegiatan Aktif & Info Lomba
        $kegiatanAktif = Event::where('tipe', 'kegiatan')->whereIn('status', ['berlangsung', 'upcoming'])->count();
        $upcomingKegiatan = Event::where('tipe', 'kegiatan')->where('status', 'upcoming')->count();
        $infoLomba = Event::where('tipe', 'lomba')->whereIn('status', ['berlangsung', 'upcoming'])->count();

        // 3. STAT CARDS: Menghitung Publikasi Riset
        $totalRiset = Report::count();
        $risetMingguIni = Report::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count();

        // 4. Aktivitas Terbaru (CRUD) - Biarkan tetap disini untuk list log teks
        $recentActivities = ActivityLog::with(['user', 'target'])
            ->where(function ($q) {
                $q->whereIn('action', ['create', 'created', 'update', 'updated', 'delete', 'deleted'])
                  ->orWhere('activity_type', 'like', '%create%')
                  ->orWhere('activity_type', 'like', '%update%')
                  ->orWhere('activity_type', 'like', '%delete%')
                  ->orWhere('activity_type', 'like', '%upload%');
            })
            ->latest()
            ->take(5)
            ->get();

        // 5. Grafik: Pertumbuhan Anggota (6 bulan terakhir)
        $memberChartData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $count = User::whereIn('role', $memberRoles)
                         ->whereMonth('created_at', $month->month)
                         ->whereYear('created_at', $month->year)
                         ->count();
                         
            $memberChartData[] = ['m' => $month->translatedFormat('M'), 'v' => $count];
        }

        // 6. DATA GRAFIK PENGUNJUNG MINGGUAN & BULANAN (Sesuai Permintaan)
        $visitorMingguan = collect(range(3, 0))->map(function ($weeksAgo) {
            $start = Carbon::now()->startOfWeek()->subWeeks($weeksAgo);
            $end = (clone $start)->endOfWeek();

            return [
                'label' => 'Minggu ' . (4 - $weeksAgo),
                'value' => ActivityLog::whereBetween('created_at', [$start, $end])
                    ->where(function ($q) { 
                        $q->where('action', 'view')->orWhere('activity_type', 'page_view'); 
                    })->count(),
            ];
        });

        $visitorBulanan = collect(range(5, 0))->map(function ($monthsAgo) {
            $start = Carbon::now()->startOfMonth()->subMonths($monthsAgo);
            $end = (clone $start)->endOfMonth();

            return [
                'label' => $start->translatedFormat('M y'),
                'value' => ActivityLog::whereBetween('created_at', [$start, $end])
                    ->where(function ($q) { 
                        $q->where('action', 'view')->orWhere('activity_type', 'page_view'); 
                    })->count(),
            ];
        });

        // 7. Data klik riset dan event
        $risetKlikData = ReportDownload::selectRaw('report_title as title, SUM(download_count) as views')
            ->groupBy('report_id', 'report_title')->orderByDesc('views')->take(6)->get();

        if ($risetKlikData->isEmpty()) {
            $risetKlikData = Report::latest()->take(6)->get(['judul_riset'])
                ->map(fn ($report) => (object) ['title' => $report->judul_riset, 'views' => 0]);
        }

        $eventKlikData = EventInteraction::join('events', 'event_interactions.event_id', '=', 'events.id')
            ->selectRaw('events.kegiatan as title, COUNT(*) as views')
            ->groupBy('events.id', 'events.kegiatan')->orderByDesc('views')->take(6)->get();

        if ($eventKlikData->isEmpty()) {
            $eventKlikData = Event::latest()->take(6)->get(['kegiatan'])
                ->map(fn ($event) => (object) ['title' => $event->kegiatan, 'views' => 0]);
        }

        // Kompilasi Chart Data (Kunjungan Website)
        $chartData = [
            'visitorMingguan' => $visitorMingguan,
            'visitorBulanan'  => $visitorBulanan,
            
            'weeklyTotal' => (int) $visitorMingguan->sum('value'),
            'weeklyAvg'   => (int) round($visitorMingguan->avg('value') ?? 0),
            'weeklyPeak'  => (int) ($visitorMingguan->max('value') ?? 0),

            'monthlyTotal' => (int) $visitorBulanan->sum('value'),
            'monthlyAvg'   => (int) round($visitorBulanan->avg('value') ?? 0),
            'monthlyPeak'  => (int) ($visitorBulanan->max('value') ?? 0),

            'risetKlikData' => $risetKlikData,
            'eventKlikData' => $eventKlikData,
            'topRisetTitle' => optional($risetKlikData->sortByDesc('views')->first())->title ?? '-',
            'topEventTitle' => optional($eventKlikData->sortByDesc('views')->first())->title ?? '-',
        ];

        $memberAverageGrowth = (int) round(collect($memberChartData)->avg('v') ?? 0);
        $activeMemberPercentage = $totalAnggota > 0
            ? (int) round(User::whereIn('role', $memberRoles)->whereNotNull('email_verified_at')->count() / $totalAnggota * 100) : 0;

        return view('admin.dashboard', compact(
            'totalAnggota', 'anggotaBulanIni', 'kegiatanAktif', 'upcomingKegiatan', 'infoLomba', 'totalRiset', 'risetMingguIni',
            'recentActivities', 'memberChartData', 'chartData', 'memberAverageGrowth', 'activeMemberPercentage'
        ));
    }
}