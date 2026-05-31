<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\HeaderController;
use App\Http\Controllers\Admin\AboutUsController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\SimulationController;
use App\Http\Controllers\Admin\DictionaryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Api\AnalyticsTrackingController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Route Register
Route::post('/register', [AuthController::class, 'register']);
// Route Login
Route::post('/login', [AuthController::class, 'login']);
// Route Admin Login
Route::post('/admin/login', [AuthController::class, 'loginAdmin']);
// Route Admin Header
Route::post('/admin/header', [HeaderController::class, 'updateApi']);
// Route Admin About Us
Route::post('/admin/about-us', [AboutUsController::class, 'updateApi']);
// Endpoint API Organisasi
Route::get('/admin/organization', [OrganizationController::class, 'indexApi']);      // GET: Lihat Data
Route::post('/admin/organization', [OrganizationController::class, 'storeApi']);     // POST: Tambah Data
Route::delete('/admin/organization/{id}', [OrganizationController::class, 'destroyApi']); // DELETE: Hapus Data
// Route API Simulasi Nabung (/admin/simulation)
Route::get('/admin/simulation', [SimulationController::class, 'getApi']);
Route::post('/admin/simulation', [SimulationController::class, 'updateApi']);
// Route API Kamus Saham (/admin/dictionary)
Route::get('/admin/dictionary', [DictionaryController::class, 'indexApi']);
Route::post('/admin/dictionary', [DictionaryController::class, 'storeApi']);
Route::delete('/admin/dictionary/{id}', [DictionaryController::class, 'destroyApi']);

Route::get('/admin/event', [EventController::class, 'indexApi']);
Route::post('/admin/event', [EventController::class, 'storeApi']);
Route::delete('/admin/event/{id}', [EventController::class, 'destroyApi']);

Route::get('/admin/report', [ReportController::class, 'indexApi']);
Route::post('/admin/report', [ReportController::class, 'storeApi']);
Route::delete('/admin/report/{id}', [ReportController::class, 'destroyApi']);

// Analytics Tracking Routes (Tanpa auth, bisa di-track anonymous users)
Route::prefix('analytics')->group(function () {
    Route::post('/track-feature', [AnalyticsTrackingController::class, 'trackFeature']);
    Route::post('/track-event', [AnalyticsTrackingController::class, 'trackEvent']);
    Route::post('/track-download', [AnalyticsTrackingController::class, 'trackDownload']);
    Route::post('/track-page', [AnalyticsTrackingController::class, 'trackPage']);
});