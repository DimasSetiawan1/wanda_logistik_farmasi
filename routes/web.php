<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\DemandDataController;
use App\Http\Controllers\EoqController;
use App\Http\Controllers\MinMaxController;
use App\Http\Controllers\EvaluationController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

// Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
});

Route::post('logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// Protected Routes
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Master Obat
    Route::resource('medicines', MedicineController::class);

    // Data Pemakaian / Permintaan
    Route::resource('demand-data', DemandDataController::class)->parameters([
        'demand-data' => 'demandDatum',
    ]);

    // Optimasi Stok
    Route::get('eoq', [EoqController::class, 'index'])->name('eoq.index');
    Route::post('eoq/calculate', [EoqController::class, 'calculate'])->name('eoq.calculate');
    Route::post('eoq/calculate-all', [EoqController::class, 'calculateAll'])->name('eoq.calculateAll');
    Route::get('eoq/result', [EoqController::class, 'result'])->name('eoq.result');

    // Batas Persediaan
    Route::get('minmax', [MinMaxController::class, 'index'])->name('minmax.index');
    Route::get('minmax/result', [MinMaxController::class, 'result'])->name('minmax.result');
    Route::get('minmax/monitoring', [MinMaxController::class, 'monitoring'])->name('minmax.monitoring');

    // Evaluasi & Prioritas
    Route::get('evaluation/abc', [EvaluationController::class, 'abcAnalysis'])->name('evaluation.abc');
    Route::get('evaluation/eoq', [EvaluationController::class, 'eoqEvaluation'])->name('evaluation.eoq');
    Route::get('evaluation/periodic', [EvaluationController::class, 'periodicReview'])->name('evaluation.periodic');
    Route::put('evaluation/parameter/{parameter}', [EvaluationController::class, 'updateParameter'])->name('evaluation.updateParameter');

    // Laporan
    Route::get('reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('reports/pdf', [ReportController::class, 'exportPdf'])->name('reports.pdf');

    // Admin Only: Kelola User
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserManagementController::class);
    });
});
