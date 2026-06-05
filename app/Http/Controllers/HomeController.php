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
use App\Models\Dictionary;
use App\Services\AnalyticsService;
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
        AnalyticsService::trackFeatureUsage('kamus');
        $terms = Dictionary::orderBy('istilah', 'asc')->get();
        return view('kamus', compact('terms'));
    }

    public function about()
    {
        $about = AboutUs::first();
        // Contoh potongan kode di Controller Anda saat melempar data ke view about
        // 1. Definisikan list divisi beserta deskripsi uniknya masing-masing
        $daftarDivisi = [
            'BPH (Badan Pengurus Harian)' => [
                'desc' => 'Inti kepemimpinan dan manajemen pusat organisasi KSPM.',
                'fullDesc' => 'Badan Pengurus Harian (BPH) bertanggung jawab atas kontrol penuh, koordinasi antar divisi, pengambilan keputusan strategis, serta manajemen keuangan dan administrasi internal KSPM SV IPB agar seluruh program kerja berjalan selaras.'
            ],
            'Administration' => [
                'desc' => 'Pengelola administrasi, surat-menyurat, dan pengarsipan digital.',
                'fullDesc' => 'Divisi Administration berfokus pada kerapian administrasi organisasi, mengelola sirkulasi surat masuk dan keluar, penyusunan proposal, laporan pertanggungjawaban (LPJ), serta bertindak sebagai pusat arsip data internal.'
            ],
            'Education' => [
                'desc' => 'Pusat edukasi, pelatihan, dan kurikulum pasar modal anggota.',
                'fullDesc' => 'Divisi Education berkomitmen meningkatkan literasi keuangan dan pasar modal bagi internal anggota maupun publik melalui kelas intensif, workshop, penyusunan modul edukasi, dan persiapan kompetisi pasar modal.'
            ],
            'Media Creative' => [
                'desc' => 'Kreator visual, branding, dan pengelola media komunikasi KSPM.',
                'fullDesc' => 'Divisi Media Creative bertanggung jawab penuh terhadap citra visual KSPM SV IPB. Tugas utamanya meliputi desain grafis konten media sosial, produksi video kreatif, fotografi kegiatan, hingga pengelolaan estetika identitas organisasi.'
            ],
            'Public Relation' => [
                'desc' => 'Jembatan hubungan eksternal dengan instansi, media, dan alumni.',
                'fullDesc' => 'Divisi Public Relation bergerak dalam membangun dan menjaga relasi strategis dengan pihak eksternal, seperti BEI, perusahaan sekuritas, komunitas pasar modal lain, media massa, serta menjaga jaringan komunikasi aktif dengan alumni KSPM.'
            ],
        ];

        // 2. Loop dan kumpulkan anggota dari database berdasarkan divisinya
        $divisiData = [];
        foreach ($daftarDivisi as $namaDivisi => $info) {
            
            // Ambil pengurus yang terdaftar di divisi ini
            $members = \App\Models\DataPengurus::where('divisi', $namaDivisi)
                ->get()
                ->map(function($m) {
                    return [
                        'nama' => $m->nama,
                        'jabatan' => $m->jabatan,
                        'foto_pengurus' => $m->foto_pengurus,
                        'initials' => strtoupper(substr($m->nama, 0, 1))
                    ];
                });

            // Gabungkan nama divisi, teks deskripsi unik, dan daftar anggotanya
            $divisiData[] = [
                'nama' => $namaDivisi,
                'desc' => $info['desc'],
                'fullDesc' => $info['fullDesc'],
                'members' => $members
            ];
        }

        // Kirim data ke view about
        return view('about', compact('about', 'divisiData'));
    }

    public function events()
    {
        AnalyticsService::trackFeatureUsage('events');
        $events = Event::where('status', '!=', 'dibatalkan')
            ->orderBy('tanggal', 'desc')
            ->get();
        
        return view('events', compact('events'));
    }

    public function gallery()
    {
        AnalyticsService::trackFeatureUsage('gallery');
        $galleries = Gallery::orderBy('created_at', 'desc')->get();
        return view('gallery', compact('galleries'));
    }

    public function eLibrary()
    {
        AnalyticsService::trackFeatureUsage('elibrary');
        $reports = Report::where('status', 'publik')
            ->orderBy('tanggal_rilis', 'desc')
            ->get();
        return view('elibrary', compact('reports'));
    }

    public function contact()
    {
        AnalyticsService::trackFeatureUsage('contact');
        $faqs = Faq::all();
        return view('contact', compact('faqs'));
    }


}
