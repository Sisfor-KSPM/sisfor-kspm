<?php

/**
 * Analytics Helper Functions
 * Include ini di functions helper Laravel
 */

use App\Services\AnalyticsService;

if (!function_exists('track_feature')) {
    /**
     * Shorten helper untuk track feature usage
     * Usage: track_feature('kalkulator')
     */
    function track_feature($featureName) {
        return AnalyticsService::trackFeatureUsage($featureName);
    }
}

if (!function_exists('track_event')) {
    /**
     * Shorten helper untuk track event interaction
     * Usage: track_event(1, 'click')
     */
    function track_event($eventId, $interactionType = 'view') {
        return AnalyticsService::trackEventInteraction($eventId, $interactionType);
    }
}

if (!function_exists('track_download')) {
    /**
     * Shorten helper untuk track report download
     * Usage: track_download(1, 'Laporan Terbaru')
     */
    function track_download($reportId, $reportTitle = null) {
        return AnalyticsService::trackReportDownload($reportId, $reportTitle);
    }
}

if (!function_exists('track_page')) {
    /**
     * Shorten helper untuk track page view
     * Usage: track_page('kamus')
     */
    function track_page($pageName) {
        return AnalyticsService::trackPageView($pageName);
    }
}

if (!function_exists('analytics_stats')) {
    /**
     * Get analytics stats
     * Usage: $stats = analytics_stats();
     */
    function analytics_stats($days = 30) {
        return AnalyticsService::getGeneralStats($days);
    }
}

if (!function_exists('most_used_features')) {
    /**
     * Get most used features
     * Usage: $features = most_used_features(10, 30);
     */
    function most_used_features($limit = 10, $days = 30) {
        return AnalyticsService::getMostUsedFeatures($limit, $days);
    }
}

if (!function_exists('most_interacted_events')) {
    /**
     * Get most interacted events
     * Usage: $events = most_interacted_events(10, 30);
     */
    function most_interacted_events($limit = 10, $days = 30) {
        return AnalyticsService::getMostInteractedEvents($limit, $days);
    }
}

if (!function_exists('most_downloaded_reports')) {
    /**
     * Get most downloaded reports
     * Usage: $reports = most_downloaded_reports(10);
     */
    function most_downloaded_reports($limit = 10) {
        return AnalyticsService::getMostDownloadedReports($limit);
    }
}

if (!function_exists('user_growth')) {
    /**
     * Get user growth stats
     * Usage: $growth = user_growth(30);
     */
    function user_growth($days = 30) {
        return AnalyticsService::getUserGrowth($days);
    }
}
