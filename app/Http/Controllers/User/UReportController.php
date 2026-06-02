<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class UReportController extends Controller
{
    public function index()
    {
        $reports = Report::orderBy('created_at', 'desc')->get();
        return view('user.riset', compact('reports'));
    }
}