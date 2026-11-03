
<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AssetController;
use App\Http\Controllers\QrCodeController;
use App\Http\Controllers\ScanController;
use App\Http\Controllers\InspectionController;
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
    | Data Aset
    |--------------------------------------------------------------------------
    */

    Route::resource('assets', AssetController::class);

    /*
    |--------------------------------------------------------------------------
    | QR Code Aset
    |--------------------------------------------------------------------------
    */

    Route::get('/assets/{asset}/qr', [QrCodeController::class, 'generate'])
        ->name('assets.qr');

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

        return view('dashboard', compact(
            'totalAssets',
            'goodAssets',
            'minorDamage',
            'majorDamage',
            'assetsNeedRepair'
        ));

    })->name('dashboard');

});
