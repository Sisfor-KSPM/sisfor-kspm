<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Services\AnalyticsService;
use Illuminate\Http\Request;

class UEventController extends Controller
{
    public function index()
    {
        // [ANALYTICS] Track halaman event yang diakses user
        AnalyticsService::trackFeatureUsage('user_events_page');
        
        $events = Event::orderBy('tanggal', 'desc')->get();
        return view('user.events', compact('events'));
    }

}