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
            'interaction_type' => 'required|string|max:100',
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
            'report_id' => 'required_without:id|integer',
            'id' => 'required_without:report_id|integer',
            'report_title' => 'nullable|string|max:255',
            'name' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:60',
        ]);

        $reportId = $request->input('report_id', $request->input('id'));
        $title = $request->input('report_title', $request->input('name'));
        $type = $request->input('type');

        if ($type) {
            AnalyticsService::trackDocumentDownload($type, $reportId, $title);
        } else {
            AnalyticsService::trackReportDownload($reportId, $title);
        }

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

    /**
     * Track pembukaan modal detail.
     * POST /api/analytics/track-modal
     * Body: { modal_type: "event_detail", target_id: 1 }
     */
    public function trackModal(Request $request)
    {
        $request->validate([
            'modal_type' => 'required|string|max:100',
            'target_id' => 'nullable|integer',
        ]);

        AnalyticsService::trackModalOpen(
            $request->modal_type,
            $request->target_id
        );

        return response()->json([
            'success' => true,
            'message' => 'Modal open tracked',
        ]);
    }

    /**
     * Track aksi kalkulator.
     * POST /api/analytics/track-calculator
     * Body: { action: "calculate_average" }
     */
    public function trackCalculator(Request $request)
    {
        $request->validate([
            'action' => 'required|string|max:100',
        ]);

        AnalyticsService::trackCalculatorAction($request->action);

        return response()->json([
            'success' => true,
            'message' => 'Calculator action tracked',
        ]);
    }

    /**
     * Track akses kamus.
     * POST /api/analytics/track-dictionary
     * Body: { id: 1, name: "Saham" }
     */
    public function trackDictionary(Request $request)
    {
        $request->validate([
            'id' => 'nullable|integer',
            'name' => 'nullable|string|max:255',
        ]);

        AnalyticsService::trackDictionaryAccess(
            $request->id,
            $request->name
        );

        return response()->json([
            'success' => true,
            'message' => 'Dictionary access tracked',
        ]);
    }
}
