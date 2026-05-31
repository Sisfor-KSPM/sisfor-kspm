<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\HomeContentController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;

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

    Route::get('/about-us', [AboutUsController::class, 'index'])->name('about.index');
    Route::put('/about-us', [AboutUsController::class, 'update'])->name('about.update');

    Route::post('/pengurus', [AboutUsController::class, 'pengurus_store'])
        ->name('pengurus.store');

    Route::get('/pengurus/{id}/edit', [AboutUsController::class, 'pengurus_edit'])
        ->name('pengurus.edit');

    Route::put('/pengurus/{id}', [AboutUsController::class, 'pengurus_update'])
        ->name('pengurus.update');

    Route::delete('/pengurus/{id}', [AboutUsController::class, 'pengurus_destroy'])
        ->name('pengurus.destroy');

    // Konten & Data
    Route::get('/anggota', function () { return view('admin.anggota'); })->name('admin.anggota');
    
    Route::get('/kegiatan', [EventController::class, 'index'])->name('admin.kegiatan');
    Route::post('/kegiatan', [EventController::class, 'store'])->name('kegiatan.store');
    Route::get('/kegiatan/{id}/edit', [EventController::class, 'edit'])->name('kegiatan.edit');
    Route::put('/kegiatan/{id}', [EventController::class, 'update'])->name('kegiatan.update');
    Route::delete('/kegiatan/{id}', [EventController::class, 'destroy'])->name('kegiatan.destroy');
    
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

    Route::get('/gallery', [GalleryController::class, 'index'])->name('admin.gallery');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('admin.gallery.store');
    Route::delete('/gallery/{id}', [GalleryController::class, 'destroy'])->name('admin.gallery.destroy');
    Route::get('/rekrutmen', function () { return view('admin.rekrutmen'); })->name('admin.rekrutmen');
    Route::get('/contact', function () { return view('admin.contact'); })->name('admin.contact');

    // Tools
    Route::get('/kalkulator', function () { return view('admin.kalkulator'); })->name('admin.kalkulator');
    Route::get('/kamus', function () { return view('admin.kamus'); })->name('admin.kamus');
    Route::get('/market', function () { return view('admin.market'); })->name('admin.market');

    // Pengaturan
    Route::get('/pengaturan', function () { return view('admin.pengaturan'); })->name('admin.pengaturan');
});