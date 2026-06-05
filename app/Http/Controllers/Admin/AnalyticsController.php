<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\AnalyticsSummary;
use App\Models\FeatureUsage;
use App\Models\ReportDownload;
use App\Models\EventInteraction;
use App\Models\User;
use App\Models\Report;
use App\Models\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    /**
     * Display analytics dashboard
     */
    public function index()
    {
        $periode = request('periode', 30);
        $startDate = Carbon::now()->subDays($periode);

        // Data User Registrasi
        $userRegistration = $this->getUserRegistrationData($periode);

        // Data Page Views (Harian)
        $pageViews = $this->getPageViewsData($periode);

        // Data Fitur Paling Banyak Dipakai
        $mostUsedFeatures = $this->getMostUsedFeatures($periode);

        // Data Riset yang Paling Banyak Didownload
        $topReports = $this->getTopReports($periode);

        // Data Event yang Paling Banyak Diklik
        $topEvents = $this->getTopEvents($periode);

        // Summary Statistics
        $stats = $this->getSummaryStatistics($periode);
        $dailyLogins = $this->getDailyLogins($periode);
        $navItems = $this->getFeaturePrefixUsage('navbar_', $periode, 10);
        $sidebarItems = $this->getFeaturePrefixUsage('sidebar_', $periode, 10);
        $calculatorActions = $this->getFeaturePrefixUsage('calculator_', $periode, 12);
        $downloadTypes = $this->getDownloadTypes($periode);

        return view('admin.analitik_new', compact(
            'userRegistration',
            'pageViews',
            'mostUsedFeatures',
            'topReports',
            'topEvents',
            'stats',
            'periode',
            'dailyLogins',
            'navItems',
            'sidebarItems',
            'calculatorActions',
            'downloadTypes'
        ));
    }

    /**
     * Get user registration data
     */
    private function getUserRegistrationData($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return User::where('created_at', '>=', $startDate)
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get page views data
     */
    private function getPageViewsData($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return ActivityLog::where('created_at', '>=', $startDate)
            ->where('action', '=', 'view')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as views, COUNT(DISTINCT user_id) as unique_visitors')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get most used features
     */
    private function getMostUsedFeatures($periode)
    {
        $startDate = Carbon::now()->subDays($periode)->toDateString();

        return FeatureUsage::where('usage_date', '>=', $startDate)
            ->selectRaw('feature_name, SUM(usage_count) as total_usage')
            ->groupBy('feature_name')
            ->orderByDesc('total_usage')
            ->take(8)
            ->get();
    }

    /**
     * Get feature usage by feature prefix
     */
    private function getFeaturePrefixUsage($prefix, $periode, $limit = 10)
    {
        $startDate = Carbon::now()->subDays($periode)->toDateString();

        return FeatureUsage::where('usage_date', '>=', $startDate)
            ->where('feature_name', 'like', $prefix . '%')
            ->selectRaw('feature_name, SUM(usage_count) as total_usage, COUNT(DISTINCT user_id) as unique_users')
            ->groupBy('feature_name')
            ->orderByDesc('total_usage')
            ->take($limit)
            ->get();
    }

    /**
     * Get user logins per day
     */
    private function getDailyLogins($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return ActivityLog::where('created_at', '>=', $startDate)
            ->where('activity_type', 'user_login')
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count, COUNT(DISTINCT user_id) as unique_users')
            ->groupBy('date')
            ->orderBy('date')
            ->get();
    }

    /**
     * Get downloads grouped by report title.
     */
    private function getDownloadTypes($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return ReportDownload::where('created_at', '>=', $startDate)
            ->selectRaw("COALESCE(NULLIF(report_title, ''), 'Tanpa Judul') as download_title, SUM(download_count) as total_downloads, COUNT(DISTINCT user_id) as unique_users")
            ->groupBy('report_id', 'report_title')
            ->orderByDesc('total_downloads')
            ->take(10)
            ->get();
    }

    /**
     * Get top downloaded reports
     */
    private function getTopReports($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return ReportDownload::where('created_at', '>=', $startDate)
            ->selectRaw('report_title, SUM(download_count) as total_downloads')
            ->groupBy('report_id', 'report_title')
            ->orderByDesc('total_downloads')
            ->take(10)
            ->get();
    }

    /**
     * Get top clicked events
     */
    private function getTopEvents($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return EventInteraction::join('events', 'event_interactions.event_id', '=', 'events.id')
            // Selesaikan masalah ambigu dengan menambahkan nama tabel di depan kolom created_at
            ->where('event_interactions.created_at', '>=', $startDate) 
            ->selectRaw('events.kegiatan as event_name, events.id as event_id, COUNT(*) as interaction_count')
            // Pastikan groupBy mencakup semua kolom non-agregat yang dipilih agar tidak error di mode Strict
            ->groupBy('events.id', 'events.kegiatan')
            ->orderByDesc('interaction_count')
            ->take(10)
            ->get();
    }

    /**
     * Get summary statistics
     */
    private function getSummaryStatistics($periode)
    {
        $startDate = Carbon::now()->subDays($periode);

        return [
            'total_page_views' => ActivityLog::where('created_at', '>=', $startDate)
                ->where('action', '=', 'view')
                ->count(),
            
            'unique_visitors' => ActivityLog::where('created_at', '>=', $startDate)
                ->where('action', '=', 'view')
                ->distinct('user_id')
                ->count('user_id'),
            
            'total_registered_users' => User::where('created_at', '>=', $startDate)->count(),
            
            'total_report_downloads' => ReportDownload::where('created_at', '>=', $startDate)
                ->sum('download_count'),
            
            'total_event_interactions' => EventInteraction::where('created_at', '>=', $startDate)->count(),
            
            'total_users' => User::count(),
            
            'today_page_views' => ActivityLog::where('created_at', '>=', Carbon::today())
                ->where('action', '=', 'view')
                ->count(),
            
            'today_new_users' => User::where('created_at', '>=', Carbon::today())->count(),
            'today_user_logins' => ActivityLog::where('created_at', '>=', Carbon::today())
                ->where('activity_type', 'user_login')
                ->count(),
            'period_user_logins' => ActivityLog::where('created_at', '>=', $startDate)
                ->where('activity_type', 'user_login')
                ->count(),
            'today_user_registers' => ActivityLog::where('created_at', '>=', Carbon::today())
                ->where('activity_type', 'user_register')
                ->count(),
        ];
    }

    /**
     * Get analytics data for API/AJAX
     */
    public function getChartData()
    {
        $periode = request('periode', 30);
        $type = request('type', 'users');
        
        switch ($type) {
            case 'users':
                return response()->json($this->getUserRegistrationData($periode));
            case 'pageviews':
                return response()->json($this->getPageViewsData($periode));
            case 'features':
                return response()->json($this->getMostUsedFeatures($periode));
            case 'reports':
                return response()->json($this->getTopReports($periode));
            case 'events':
                return response()->json($this->getTopEvents($periode));
            default:
                return response()->json([]);
        }
    }

    /**
     * Log user activity (called from middleware)
     */
    public static function logActivity($pageName, $featureName = null, $action = 'view', $targetType = null, $targetId = null)
    {
        try {
            ActivityLog::create([
                'user_id' => auth()->id(),
                'page_name' => $pageName,
                'feature_name' => $featureName,
                'action' => $action,
                'target_type' => $targetType,
                'target_id' => $targetId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Log error silently
        }
    }

    /**
     * Log feature usage
     */
    public static function logFeatureUsage($featureName)
    {
        try {
            $today = Carbon::today();
            
            FeatureUsage::updateOrCreate(
                [
                    'feature_name' => $featureName,
                    'user_id' => auth()->id(),
                    'usage_date' => $today,
                ],
                [
                    'usage_count' => DB::raw('usage_count + 1'),
                ]
            );
        } catch (\Exception $e) {
            // Log error silently
        }
    }

    /**
     * Log report download
     */
    public static function logReportDownload($reportId, $reportTitle)
    {
        try {
            $today = Carbon::today();
            
            ReportDownload::updateOrCreate(
                [
                    'report_id' => $reportId,
                    'user_id' => auth()->id(),
                ],
                [
                    'report_title' => $reportTitle,
                    'download_count' => DB::raw('download_count + 1'),
                    'last_download_date' => $today,
                ]
            );

            ActivityLog::create([
                'user_id' => auth()->id(),
                'page_name' => 'elibrary',
                'feature_name' => 'download_report',
                'action' => 'download',
                'target_type' => 'report',
                'target_id' => $reportId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Log error silently
        }
    }

    /**
     * Log event interaction
     */
    public static function logEventInteraction($eventId, $interactionType = 'view')
    {
        try {
            EventInteraction::create([
                'event_id' => $eventId,
                'user_id' => auth()->id(),
                'interaction_type' => $interactionType,
            ]);

            ActivityLog::create([
                'user_id' => auth()->id(),
                'page_name' => 'events',
                'feature_name' => 'event_' . $interactionType,
                'action' => $interactionType,
                'target_type' => 'event',
                'target_id' => $eventId,
                'ip_address' => request()->ip(),
                'user_agent' => request()->header('User-Agent'),
            ]);
        } catch (\Exception $e) {
            // Log error silently
        }
    }
}
