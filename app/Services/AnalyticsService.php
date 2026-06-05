<?php

namespace App\Services;

use App\Models\FeatureUsage;
use App\Models\EventInteraction;
use App\Models\ReportDownload;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class AnalyticsService
{
    private static function currentPageName(): string
    {
        return request()->route()?->getName() ?? trim(request()->path(), '/') ?: 'home';
    }

    private static function defaultActionFor($activityType): string
    {
        $type = strtolower($activityType);
        
        // Tambahkan pengenalan otomatis untuk CRUD
        if (str_contains($type, 'create') || str_contains($type, 'upload') || str_contains($type, 'store')) return 'create';
        if (str_contains($type, 'update') || str_contains($type, 'edit')) return 'update';
        if (str_contains($type, 'delete') || str_contains($type, 'destroy')) return 'delete';

        return match ($activityType) {
            'page_view', 'dictionary_access' => 'view',
            'report_download', 'document_download' => 'download',
            'modal_open' => 'open',
            'calculator_action' => 'calculate',
            'user_login' => 'login',
            'user_register' => 'register',
            'event_interaction' => 'interaction',
            default => 'use',
        };
    }

    /**
     * Track penggunaan fitur
     */
    public static function trackFeatureUsage($featureName, $userId = null)
    {
        $userId = $userId ?? Auth::id();

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

        self::logActivity($userId, 'feature_usage', $featureName, [
            'page_name' => self::currentPageName(),
            'feature_name' => $featureName,
            'action' => 'click',
        ]);
        
        return true;
    }

    /**
     * Track interaksi dengan event
     */
    public static function trackEventInteraction($eventId, $interactionType = 'view', $userId = null)
    {
        $userId = $userId ?? Auth::id();

        if ($eventId) {
            EventInteraction::create([
                'event_id' => $eventId,
                'user_id' => $userId,
                'interaction_type' => $interactionType,
            ]);
        }

        self::logActivity($userId, 'event_interaction', "Event ID: $eventId - $interactionType", [
            'page_name' => self::currentPageName(),
            'feature_name' => 'event_' . $interactionType,
            'action' => $interactionType,
            'target_type' => 'event',
            'target_id' => $eventId,
        ]);
        
        return true;
    }

    /**
     * Track unduhan report/riset
     */
    public static function trackReportDownload($reportId, $reportTitle = null, $userId = null)
    {
        $userId = $userId ?? Auth::id();

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

        self::logActivity($userId, 'report_download', "Report: $reportTitle (ID: $reportId)", [
            'page_name' => self::currentPageName(),
            'feature_name' => 'download_report',
            'action' => 'download',
            'target_type' => 'report',
            'target_id' => $reportId,
        ]);
        
        return true;
    }

    /**
     * Track akses halaman
     */
    public static function trackPageView($pageName, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        self::logActivity($userId, 'page_view', $pageName, [
            'page_name' => $pageName,
            'feature_name' => $pageName,
            'action' => 'view',
        ]);
        
        return true;
    }

    /**
     * Log activity umum
     */
    public static function logActivity($userId, $activityType, $description = null, array $meta = [])
    {
        ActivityLog::create([
            'user_id' => $userId,
            'page_name' => $meta['page_name'] ?? null,
            'activity_type' => $activityType,
            'description' => $description,
            'feature_name' => $meta['feature_name'] ?? null,
            'action' => $meta['action'] ?? self::defaultActionFor($activityType),
            'target_type' => $meta['target_type'] ?? null,
            'target_id' => $meta['target_id'] ?? null,
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
     * Dapatkan event yang paling banyak diklik (fixed untuk PostgreSQL)
     */
    public static function getMostInteractedEvents($limit = 10, $days = 30)
    {
        $fromDate = now()->subDays($days)->toDateTimeString();
        
        return EventInteraction::where('created_at', '>=', $fromDate)
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
     * Dapatkan statistik general (fixed untuk PostgreSQL)
     */
    public static function getGeneralStats($days = 30)
    {
        $fromDate = now()->subDays($days)->toDateTimeString();

        return [
            'total_users' => \App\Models\User::count(),
            'new_users' => \App\Models\User::where('created_at', '>=', $fromDate)->count(),
            'total_feature_usage' => FeatureUsage::where('usage_date', '>=', now()->subDays($days)->toDateString())->sum('usage_count'),
            'total_event_interactions' => EventInteraction::where('created_at', '>=', $fromDate)->count(),
            'total_report_downloads' => ReportDownload::sum('download_count'),
            'unique_active_users' => ActivityLog::where('created_at', '>=', $fromDate)->distinct('user_id')->count('user_id'),
        ];
    }

    /**
     * Track pembukaan modal (untuk event modal di event & user events)
     */
    public static function trackModalOpen($modalType, $targetId = null, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        self::logActivity($userId, 'modal_open', "$modalType - ID: $targetId", [
            'page_name' => self::currentPageName(),
            'feature_name' => 'modal_' . $modalType,
            'action' => 'open',
            'target_type' => str_contains($modalType, 'event') ? 'event' : 'modal',
            'target_id' => $targetId,
        ]);
        self::trackEventInteraction($targetId, "modal_open_$modalType", $userId);
        
        return true;
    }

    /**
     * Track download file/dokumen (untuk elibrary, user riset, kamus, dll)
     */
    public static function trackDocumentDownload($documentType, $documentId, $documentName = null, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        $today = now()->toDateString();

        // Track sebagai report download jika ada report_id
        if ($documentType === 'report' || $documentType === 'riset' || $documentType === 'elibrary') {
            self::trackReportDownload($documentId, $documentName ?? "$documentType-$documentId", $userId);
        }

        // Track sebagai feature usage
        self::trackFeatureUsage("download_$documentType", $userId);

        // Log activity dengan detail
        self::logActivity($userId, 'document_download', "$documentType: $documentName (ID: $documentId)", [
            'page_name' => self::currentPageName(),
            'feature_name' => "download_$documentType",
            'action' => 'download',
            'target_type' => $documentType,
            'target_id' => $documentId,
        ]);
        
        return true;
    }

    /**
     * Track akses kamus/dictionary (untuk elibrary & user kamus)
     */
    public static function trackDictionaryAccess($dictionaryId, $dictionaryName = null, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        // Track sebagai feature usage
        self::trackFeatureUsage('dictionary_access', $userId);

        // Log activity detail
        self::logActivity($userId, 'dictionary_access', "Kamus: $dictionaryName (ID: $dictionaryId)", [
            'page_name' => self::currentPageName(),
            'feature_name' => 'dictionary_access',
            'action' => 'view',
            'target_type' => 'dictionary',
            'target_id' => $dictionaryId,
        ]);
        
        return true;
    }

    /**
     * Track aksi kalkulator (untuk user kalkulator dengan berbagai trigger)
     * Triggers: calculate_average, calculate_profit_loss, calculate_bep, 
     *           calculate_total_fee, calculate_dividend_neto, calculate_valuation
     */
    public static function trackCalculatorAction($actionType, $userId = null)
    {
        $userId = $userId ?? Auth::id();

        // Track sebagai feature usage
        self::trackFeatureUsage("calculator_$actionType", $userId);

        // Log activity detail
        self::logActivity($userId, 'calculator_action', "Kalkulator: $actionType", [
            'page_name' => self::currentPageName(),
            'feature_name' => "calculator_$actionType",
            'action' => 'calculate',
            'target_type' => 'calculator',
        ]);
        
        return true;
    }

    /**
     * Dapatkan statistik interaksi user detail untuk periode tertentu
     */
    public static function getUserInteractionStats($userId, $days = 30)
    {
        $fromDate = now()->subDays($days)->toDateTimeString();

        return [
            'feature_uses' => FeatureUsage::where('user_id', $userId)
                ->where('usage_date', '>=', now()->subDays($days)->toDateString())
                ->sum('usage_count'),
            'event_interactions' => EventInteraction::where('user_id', $userId)
                ->where('created_at', '>=', $fromDate)
                ->count(),
            'downloads' => ReportDownload::where('user_id', $userId)
                ->sum('download_count'),
            'activities' => ActivityLog::where('user_id', $userId)
                ->where('created_at', '>=', $fromDate)
                ->count(),
        ];
    }
}
