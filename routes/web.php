<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\HomeContentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [HomeController::class, 'index']);
Route::get('/kamus', [HomeController::class, 'kamus']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/events', [HomeController::class, 'events']);
Route::get('/gallery', [HomeController::class, 'gallery']);
Route::get('/elibrary', [HomeController::class, 'eLibrary']);
Route::get('/contact', [HomeController::class, 'contact']);

Route::prefix('user')->group(function () {
    // Overview
    Route::get('/dashboard', function () { return view('user.dashboard'); })->name('user.dashboard');
    Route::get('event', function () { return view('user.event'); })->name('user.event');
    Route::get('kalkulator', function () { return view('user.kalkulator'); })->name('user.kalkulator');
    Route::get('kamus', function () { return view('user.kamus'); })->name('user.kamus');
    Route::get('pengaturan', function () { return view('user.pengaturan'); })->name('user.pengaturan');
});

Route::prefix('admin')->group(function () {
    // Overview
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/analitik', function () { return view('admin.analitik'); })->name('admin.analitik');

    // Konten & Data
    Route::get('/anggota', function () { return view('admin.anggota'); })->name('admin.anggota');
    Route::get('/kegiatan', function () { return view('admin.kegiatan'); })->name('admin.kegiatan');
    Route::get('/lomba', function () { return view('admin.lomba'); })->name('admin.lomba');
    Route::get('/riset', function () { return view('admin.riset'); })->name('admin.riset');
    Route::get('/pengumuman', function () { return view('admin.pengumuman'); })->name('admin.pengumuman');
    
    // Fitur Esensial
    Route::get('/faq', function () { return view('admin.faq'); })->name('admin.faq');
    Route::get('/reviews', function () { return view('admin.reviews'); })->name('admin.reviews');

    // Halaman Landing
    Route::get('/home-content', [HomeContentController::class, 'index'])
        ->name('admin.home-content');
    Route::post('/home-content', [HomeContentController::class, 'update'])
        ->name('admin.home-content.update');

    Route::get('/about-us', function () { return view('admin.about_us.edit'); })->name('admin.about_us.edit');
    Route::get('/gallery', function () { return view('admin.gallery'); })->name('admin.gallery');
    Route::get('/rekrutmen', function () { return view('admin.rekrutmen'); })->name('admin.rekrutmen');
    Route::get('/contact', function () { return view('admin.contact'); })->name('admin.contact');

    // Tools
    Route::get('/kalkulator', function () { return view('admin.kalkulator'); })->name('admin.kalkulator');
    Route::get('/kamus', function () { return view('admin.kamus'); })->name('admin.kamus');
    Route::get('/market', function () { return view('admin.market'); })->name('admin.market');

    // Pengaturan
    Route::get('/pengaturan', function () { return view('admin.pengaturan'); })->name('admin.pengaturan');
});