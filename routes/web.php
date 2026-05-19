<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesController;

// Redirect root ke login
Route::get('/', function () {
    return redirect()->route('login');
});

// Login page
Route::get('/login', function () {
    return view('login');
})->name('login');

// Dashboard (main app)
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Sales API routes
Route::post('/sales/store', [SalesController::class, 'store'])->name('sales.store');
Route::get('/sales/report-data', [SalesController::class, 'getReportData']);

Route::get('/sales/master-material', [SalesController::class, 'getMasterMaterial']);
Route::get('/sales/master-salesman', [SalesController::class, 'getMasterSalesman']);

// Master Material
Route::post('/master/material/store',       [SalesController::class, 'storeMaterial']);
Route::put('/master/material/{id}',         [SalesController::class, 'updateMaterial']);

// Master Salesman
Route::post('/master/salesman/store',       [SalesController::class, 'storeSalesman']);
Route::put('/master/salesman/{id}',         [SalesController::class, 'updateSalesman']);