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