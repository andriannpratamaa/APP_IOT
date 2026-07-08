<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\ExportController;
use App\Http\Controllers\Api\MonitoringController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes (ESP32)
|--------------------------------------------------------------------------
*/
Route::post('monitorings', [MonitoringController::class, 'store'])->name('api.monitorings.store');

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/
Route::post('login', [AuthController::class, 'login'])->name('api.login');

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('logout', [AuthController::class, 'logout'])->name('api.logout');
    Route::get('profile', [AuthController::class, 'profile'])->name('api.profile');
    Route::put('profile', [AuthController::class, 'updateProfile'])->name('api.profile.update');
    Route::put('change-password', [AuthController::class, 'changePassword'])->name('api.change-password');

    // Dashboard
    Route::get('dashboard', [DashboardController::class, 'index'])->name('api.dashboard');

    // Devices
    Route::apiResource('devices', DeviceController::class)->names([
        'index' => 'api.devices.index',
        'show' => 'api.devices.show',
        'store' => 'api.devices.store',
        'update' => 'api.devices.update',
        'destroy' => 'api.devices.destroy',
    ]);

    // Monitoring
    Route::get('monitorings/latest', [MonitoringController::class, 'latest'])->name('api.monitorings.latest');
    Route::get('monitorings/history', [MonitoringController::class, 'history'])->name('api.monitorings.history');
    Route::get('monitorings/chart', [MonitoringController::class, 'chart'])->name('api.monitorings.chart');
    Route::get('monitorings/{id}', [MonitoringController::class, 'show'])->name('api.monitorings.show');

    // Export
    Route::get('export/excel', [ExportController::class, 'export'])->name('api.export.excel');
});
