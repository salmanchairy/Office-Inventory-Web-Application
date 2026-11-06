<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\AssetMovementController;
use App\Models\Asset;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Halaman yang membutuhkan login
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    |--------------------------------------------------------------------------
    | QR Code Aset (Ditempatkan sebelum Route::resource)
    |--------------------------------------------------------------------------
    */

    Route::get('/assets/{asset}/qr', [QrCodeController::class, 'generate'])
        ->name('assets.qr');
    Route::get('/assets/{asset}/qr/print', [QrCodeController::class, 'print'])
        ->name('assets.qr.print');

    /*
    |--------------------------------------------------------------------------
    | Data Aset & Master Data
    |--------------------------------------------------------------------------
    */

    Route::resource('assets', AssetController::class);
    Route::get('/assets/{asset}/move', [AssetMovementController::class, 'create'])->name('assets.move.create');
    Route::post('/assets/{asset}/move', [AssetMovementController::class, 'store'])->name('assets.move.store');

    Route::get('/reports/assets', [ReportController::class, 'index'])
        ->name('reports.assets');

    Route::get('/reports/assets/export', [ReportController::class, 'export'])
        ->name('reports.assets.export');

    Route::resource('categories', CategoryController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('locations', LocationController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    Route::resource('users', UserController::class)
        ->only(['index', 'store', 'update', 'destroy']);

    /*
    |--------------------------------------------------------------------------
    | Peta Persebaran & API Map
    |--------------------------------------------------------------------------
    */

    Route::get('/peta-persebaran', [MapController::class, 'index'])
        ->name('maps.index');

    Route::get('/api/map/locations', [LocationController::class, 'apiLocations'])
        ->name('api.map.locations');

    /*
    |--------------------------------------------------------------------------
    | Scan QR / Barcode
    |--------------------------------------------------------------------------
    */

    Route::get('/scan', [ScanController::class, 'index'])
        ->name('scan.index');

    Route::get('/scan/find-asset/{asset_code}', [ScanController::class, 'findAsset'])
        ->name('scan.find-asset');

    /*
    |--------------------------------------------------------------------------
    | Pemeriksaan Aset
    |--------------------------------------------------------------------------
    */

    // Daftar aset yang dapat diperiksa
    Route::get('/inspections', [InspectionController::class, 'index'])
        ->name('inspections.index');

    // Riwayat seluruh pemeriksaan aset
    Route::get('/inspections/history', [InspectionController::class, 'history'])
        ->name('inspections.history');

    // Detail satu hasil pemeriksaan aset
    Route::get('/inspections/history/{inspection}', [InspectionController::class, 'show'])
        ->name('inspections.show');

    // Form pemeriksaan aset
    Route::get('/assets/{asset}/inspect', [InspectionController::class, 'create'])
        ->name('inspections.create');

    // Simpan hasil pemeriksaan aset
    Route::post('/assets/{asset}/inspect', [InspectionController::class, 'store'])
        ->name('inspections.store');

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/', function () {

        $totalAssets = Asset::count();

        $goodAssets = Asset::where('condition', 'Baik')->count();

        $minorDamage = Asset::where('condition', 'Rusak Ringan')->count();

        $majorDamage = Asset::where('condition', 'Rusak Berat')->count();

        $assetsNeedRepair = Asset::with(['category', 'location'])
            ->whereIn('condition', ['Rusak Ringan', 'Rusak Berat'])
            ->latest()
            ->take(5)
            ->get();

        $overdueInspections = Asset::whereDoesntHave('inspections', function ($query) {
            $query->whereDate('inspection_date', '>=', now()->subDays(90));
        })->count();

        $criticalAssets = Asset::where('condition', 'Rusak Berat')->count();

        return view('dashboard', compact(
            'totalAssets',
            'goodAssets',
            'minorDamage',
            'majorDamage',
            'assetsNeedRepair',
            'overdueInspections',
            'criticalAssets'
        ));

    })->name('dashboard');

});
