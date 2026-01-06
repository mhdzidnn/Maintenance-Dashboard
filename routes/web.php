<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NextcloudController;
use App\Http\Controllers\ProxmoxController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\DummyAuth;

// Public Auth Routes
Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Routes
Route::middleware([DummyAuth::class])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Proxmox Section
    Route::get('/proxmox', [ProxmoxController::class, 'index'])->name('proxmox.index');
    Route::get('/proxmox/nodes/{location?}', [ProxmoxController::class, 'nodes'])->name('proxmox.nodes');

    // Nextcloud Section
    Route::get('/nextcloud', [NextcloudController::class, 'index'])->name('nextcloud.index');
    Route::get('/nextcloud/overview', [NextcloudController::class, 'overview'])->name('nextcloud.overview');
    Route::get('/nextcloud/users', [NextcloudController::class, 'users'])->name('nextcloud.users');
    Route::get('/nextcloud/storage', [NextcloudController::class, 'storage'])->name('nextcloud.storage');

    // System Section
    Route::get('/system', [SystemController::class, 'index'])->name('system.index');
    Route::get('/system/alerts', [SystemController::class, 'alerts'])->name('system.alerts');
    Route::get('/system/logs', [SystemController::class, 'logs'])->name('system.logs');
});
