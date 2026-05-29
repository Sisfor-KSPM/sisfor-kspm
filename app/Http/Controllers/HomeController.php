<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $header = Header::first(); // null-safe, view sudah handle kalau null
        return view('welcome', compact('header'));
    }
}
