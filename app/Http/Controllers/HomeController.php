<?php

namespace App\Http\Controllers;

use App\Models\Header;
use Illuminate\Http\Request;
use App\Models\homecontent;
use App\Models\AboutUs;
use App\Models\DataPengurus;

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
        return view('events');
    }

    public function gallery()
    {
        $galleries = collect([

            (object)[
                'id' => 1,
                'title' => 'Investalk Vol. 5 — Sesi Diskusi',
                'event_name' => 'Investalk 2025',
                'category' => 'investalk',
                'image' => 'gallery/investalk1.jpg',
            ],

            (object)[
                'id' => 2,
                'title' => 'Sekolah Pasar Modal Batch 12',
                'event_name' => 'Sekolah Pasar Modal',
                'category' => 'sekolah',
                'image' => 'gallery/spm1.jpg',
            ],

            (object)[
                'id' => 3,
                'title' => 'Company Visit Bursa Efek Indonesia',
                'event_name' => 'Company Visit 2025',
                'category' => 'company',
                'image' => 'gallery/company1.jpg',
            ],

            (object)[
                'id' => 4,
                'title' => 'Stock Trading Competition',
                'event_name' => 'ISTC 2025',
                'category' => 'kompetisi',
                'image' => 'gallery/kompetisi1.jpg',
            ],

            (object)[
                'id' => 5,
                'title' => 'Pelantikan Anggota Baru',
                'event_name' => 'Internal KSPM',
                'category' => 'internal',
                'image' => 'gallery/internal1.jpg',
            ],

            (object)[
                'id' => 6,
                'title' => 'Market Outlook Discussion',
                'event_name' => 'Investalk 2025',
                'category' => 'investalk',
                'image' => 'gallery/investalk2.jpg',
            ],

            (object)[
                'id' => 7,
                'title' => 'Workshop Analisis Teknikal',
                'event_name' => 'Sekolah Pasar Modal',
                'category' => 'sekolah',
                'image' => 'gallery/spm2.jpg',
            ],

            (object)[
                'id' => 8,
                'title' => 'Kunjungan ke IDX Jakarta',
                'event_name' => 'Company Visit',
                'category' => 'company',
                'image' => 'gallery/company2.jpg',
            ],

        ]);
        return view('gallery', compact('galleries'));
    }

    public function eLibrary()
    {
        return view('elibrary');
    }

    public function contact()
    {
        return view('contact');
    }


}
