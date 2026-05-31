<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use App\Models\homecontent;
use App\Models\AboutUs;
use App\Models\DataPengurus;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\Report;
use App\Models\Faq;
use Illuminate\Support\Facades\File;

class HomeController extends Controller
{
    public function index()
    {
        $home = Homecontent::first();
        $header = Header::first(); // null-safe, view sudah handle kalau null
        return view('welcome', compact('header', 'home'));
    }

    public function kamus()
    {
        return view('kamus');
    }

    public function about()
    {
        $about = AboutUs::first();
        $pengurusByDivisi = DataPengurus::latest()->get()->groupBy('divisi');
        
        // Format divisions data for frontend
        $divisiData = $pengurusByDivisi->map(function($members, $divisi) {
            return [
                'nama' => $divisi,
                'desc' => 'Divisi ' . $divisi,
                'fullDesc' => 'Tim dari divisi ' . $divisi . ' bekerja untuk mencapai tujuan organisasi.',
                'members' => $members->map(function($member) {
                    return [
                        'initials' => strtoupper(substr($member->nama, 0, 1)),
                        'name' => $member->nama,
                        'role' => $member->jabatan
                    ];
                })->values()->toArray()
            ];
        })->values()->toArray();
        
        return view('about', compact('about', 'divisiData'));
    }

    public function events()
    {
        $events = Event::where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('events', compact('events'));
    }

    public function gallery()
    {
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('gallery', compact('galleries'));
    }

    public function eLibrary()
    {
        $reports = Report::where('status', 'publik')
            ->orderBy('tanggal_rilis', 'desc')
            ->get();
        return view('elibrary', compact('reports'));
    }

    public function contact()
    {
        $faqs = Faq::all();
        return view('contact', compact('faqs'));
    }


}
