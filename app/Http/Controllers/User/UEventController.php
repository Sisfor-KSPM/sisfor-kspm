<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class UEventController extends Controller
{
    public function index()
    {
        $events = Event::orderBy('tanggal', 'desc')->get();
        return view('user.events', compact('events'));
    }

}