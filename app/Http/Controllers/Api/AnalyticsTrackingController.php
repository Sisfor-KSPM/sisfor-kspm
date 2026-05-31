<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class AnalyticsTrackingController extends Controller
{
    /**
     * Track penggunaan fitur
     * POST /api/analytics/track-feature
     * Body: { feature_name: "kalkulator" }
     */
    public function trackFeature(Request $request)
    {
        $request->validate([
            'feature_name' => 'required|string|max:100',
        ]);

        AnalyticsService::trackFeatureUsage($request->feature_name);

        return response()->json([
            'success' => true,
            'message' => 'Feature usage tracked',
        ]);
    }

    /**
     * Track interaksi event
     * POST /api/analytics/track-event
     * Body: { event_id: 1, interaction_type: "click" }
     */
    public function trackEvent(Request $request)
    {
        $request->validate([
            'event_id' => 'required|integer',
            'interaction_type' => 'required|string|in:view,click,attend,interested',
        ]);

        AnalyticsService::trackEventInteraction(
            $request->event_id,
            $request->interaction_type
        );

        return response()->json([
            'success' => true,
            'message' => 'Event interaction tracked',
        ]);
    }

    /**
     * Track unduhan report
     * POST /api/analytics/track-download
     * Body: { report_id: 1, report_title: "Report Terbaru" }
     */
    public function trackDownload(Request $request)
    {
        $request->validate([
            'report_id' => 'required|integer',
            'report_title' => 'nullable|string|max:255',
        ]);

        AnalyticsService::trackReportDownload(
            $request->report_id,
            $request->report_title
        );

        return response()->json([
            'success' => true,
            'message' => 'Download tracked',
        ]);
    }

    /**
     * Track akses halaman umum
     * POST /api/analytics/track-page
     * Body: { page_name: "kamus" }
     */
    public function trackPage(Request $request)
    {
        $request->validate([
            'page_name' => 'required|string|max:100',
        ]);

        AnalyticsService::trackPageView($request->page_name);

        return response()->json([
            'success' => true,
            'message' => 'Page view tracked',
        ]);
    }
}
