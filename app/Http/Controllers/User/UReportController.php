<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UReportController extends Controller
{
    public function index()
    {
        // [ANALYTICS] Track halaman riset/report yang diakses user
        AnalyticsService::trackFeatureUsage('user_report_page');
        
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('user.riset', compact('reports'));
    }
}