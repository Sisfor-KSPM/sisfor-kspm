<?php

namespace App\Services;

use App\Models\FeatureUsage;
use App\Models\EventInteraction;
use App\Models\ReportDownload;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AnalyticsService
{
    /**
     * Track penggunaan fitur
     */
    public static function trackFeatureUsage($featureName, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) return false;

        $today = now()->toDateString();

        $feature = FeatureUsage::where('feature_name', $featureName)
            ->where('user_id', $userId)
            ->where('usage_date', $today)
            ->first();

        if ($feature) {
            $feature->increment('usage_count');
        } else {
            FeatureUsage::create([
                'feature_name' => $featureName,
                'user_id' => $userId,
                'usage_count' => 1,
                'usage_date' => $today,
            ]);
        }

        // Log activity
        self::logActivity($userId, 'feature_usage', $featureName);
        
        return true;
    }

    /**
     * Track interaksi dengan event
     */
    public static function trackEventInteraction($eventId, $interactionType = 'view', $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) return false;

        EventInteraction::create([
            'event_id' => $eventId,
            'user_id' => $userId,
            'interaction_type' => $interactionType,
        ]);

        // Log activity
        self::logActivity($userId, 'event_interaction', "Event ID: $eventId - $interactionType");
        
        return true;
    }

    /**
     * Track unduhan report/riset
     */
    public static function trackReportDownload($reportId, $reportTitle = null, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) return false;

        $today = now()->toDateString();

        $report = ReportDownload::where('report_id', $reportId)
            ->where('user_id', $userId)
            ->first();

        if ($report) {
            $report->increment('download_count');
            $report->update(['last_download_date' => $today]);
        } else {
            ReportDownload::create([
                'report_id' => $reportId,
                'user_id' => $userId,
                'report_title' => $reportTitle ?? 'Report ' . $reportId,
                'download_count' => 1,
                'last_download_date' => $today,
            ]);
        }

        // Log activity
        self::logActivity($userId, 'report_download', "Report: $reportTitle (ID: $reportId)");
        
        return true;
    }

    /**
     * Track akses halaman
     */
    public static function trackPageView($pageName, $userId = null)
    {
        $userId = $userId ?? Auth::id();
        
        if (!$userId) return false;

        self::logActivity($userId, 'page_view', $pageName);
        
        return true;
    }

    /**
     * Log activity umum
     */
    public static function logActivity($userId, $activityType, $description = null)
    {
        ActivityLog::create([
            'user_id' => $userId,
            'activity_type' => $activityType,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Dapatkan fitur yang paling sering digunakan
     */
    public static function getMostUsedFeatures($limit = 10, $days = 30)
    {
        return FeatureUsage::where('usage_date', '>=', now()->subDays($days)->toDateString())
            ->groupBy('feature_name')
            ->selectRaw('feature_name, SUM(usage_count) as total_uses, COUNT(DISTINCT user_id) as unique_users')
            ->orderBy('total_uses', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Dapatkan event yang paling banyak diklik
     */
    public static function getMostInteractedEvents($limit = 10, $days = 30)
    {
        return EventInteraction::where('created_at', '>=', now()->subDays($days))
            ->groupBy('event_id')
            ->selectRaw('event_id, COUNT(*) as interaction_count, COUNT(DISTINCT user_id) as unique_users')
            ->orderBy('interaction_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Dapatkan riset yang paling sering didownload
     */
    public static function getMostDownloadedReports($limit = 10)
    {
        return ReportDownload::orderBy('download_count', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Dapatkan pertumbuhan registrasi user
     */
    public static function getUserGrowth($days = 30)
    {
        return \App\Models\User::where('created_at', '>=', now()->subDays($days))
            ->groupBy(\DB::raw('DATE(created_at)'))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->orderBy('date', 'asc')
            ->get();
    }

    /**
     * Dapatkan statistik general
     */
    public static function getGeneralStats($days = 30)
    {
        $fromDate = now()->subDays($days)->toDateString();

        return [
            'total_users' => \App\Models\User::count(),
            'new_users' => \App\Models\User::where('created_at', '>=', $fromDate)->count(),
            'total_feature_usage' => FeatureUsage::where('usage_date', '>=', $fromDate)->sum('usage_count'),
            'total_event_interactions' => EventInteraction::where('created_at', '>=', $fromDate)->count(),
            'total_report_downloads' => ReportDownload::sum('download_count'),
            'unique_active_users' => ActivityLog::where('created_at', '>=', $fromDate)->distinct('user_id')->count('user_id'),
        ];
    }
}
