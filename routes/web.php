<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\admin\HomeContentController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\AnalyticsController;
use App\Http\Controllers\User\UEventController;
use App\Http\Controllers\User\UDictionaryController;
use App\Http\Controllers\User\UReportController;

Route::get('/loginadmin', function () { return view('loginadmin'); })->name('admin.login');
Route::get('/lupapwadmin', function () { return view('lupapwadmin'); })->name('admin.lupapw');
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
    Route::get('/events', [UEventController::class, 'index'])->name('user.events');
    Route::get('/kamus', [UDictionaryController::class, 'index'])->name('user.kamus');
    Route::get('/riset', [UReportController::class, 'index'])->name('user.riset');
    Route::get('/kalkulator', function () { return view('user.kalkulator'); })->name('user.kalkulator');
    Route::get('/pengaturan', function () { return view('user.pengaturan'); })->name('user.pengaturan');
});

Route::prefix('admin')->group(function () {
    // Overview
    Route::get('/dashboard', function () { return view('admin.dashboard'); })->name('admin.dashboard');
    Route::get('/analitik', [AnalyticsController::class, 'index'])->name('admin.analitik');
    Route::get('/api/analytics', [AnalyticsController::class, 'getChartData'])->name('admin.analitik.api');

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
    Route::get('/riset', [ReportController::class, 'index'])->name('admin.riset');
    Route::post('/riset', [ReportController::class, 'store'])->name('admin.riset.store');
    Route::delete('/riset/{id}', [ReportController::class, 'destroy'])->name('admin.riset.destroy');
   
    // Fitur Esensial
    Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
    Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
    Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
    Route::delete('/faq/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

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
   
    Route::get('/kamus', [DictionaryController::class, 'index'])->name('kamus.index');
    Route::post('/kamus', [DictionaryController::class, 'store'])->name('kamus.store');
    Route::put('/kamus/{id}', [DictionaryController::class, 'update'])->name('kamus.update');
    Route::delete('/kamus/{id}', [DictionaryController::class, 'destroy'])->name('kamus.destroy');
    
    // Pengaturan
    Route::get('/pengaturan', function () { return view('admin.pengaturan'); })->name('admin.pengaturan');
});