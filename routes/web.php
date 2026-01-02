<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\NextcloudController;
use App\Http\Controllers\ProxmoxController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Proxmox Section
Route::get('/proxmox', [ProxmoxController::class, 'index'])->name('proxmox.index');
Route::get('/proxmox/nodes', [ProxmoxController::class, 'nodes'])->name('proxmox.nodes');
Route::get('/proxmox/storage', [ProxmoxController::class, 'storage'])->name('proxmox.storage');
Route::get('/proxmox/vms', [ProxmoxController::class, 'vms'])->name('proxmox.vms');
Route::get('/proxmox/memory', [ProxmoxController::class, 'memory'])->name('proxmox.memory');

// Nextcloud Section
Route::get('/nextcloud', [NextcloudController::class, 'index'])->name('nextcloud.index');
Route::get('/nextcloud/overview', [NextcloudController::class, 'overview'])->name('nextcloud.overview');
Route::get('/nextcloud/users', [NextcloudController::class, 'users'])->name('nextcloud.users');
Route::get('/nextcloud/storage', [NextcloudController::class, 'storage'])->name('nextcloud.storage');

// System Section
Route::get('/system', [SystemController::class, 'index'])->name('system.index');
Route::get('/system/alerts', [SystemController::class, 'alerts'])->name('system.alerts');
Route::get('/system/logs', [SystemController::class, 'logs'])->name('system.logs');
