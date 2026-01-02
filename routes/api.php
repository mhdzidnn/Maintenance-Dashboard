<?php

use App\Http\Controllers\Api\NodeController;
use App\Http\Controllers\Api\StorageController;
use App\Http\Controllers\Api\VMController;
use App\Http\Controllers\Api\NextcloudController;
use App\Http\Controllers\Api\AlertController;
use Illuminate\Support\Facades\Route;

Route::get('/nodes', [NodeController::class, 'index']);
Route::get('/nodes/{id}/health', [NodeController::class, 'show']);

Route::get('/storage/health', [StorageController::class, 'index']);

Route::get('/vms/top-usage', [VMController::class, 'topUsage']);

Route::get('/nextcloud/overview', [NextcloudController::class, 'overview']);
Route::get('/nextcloud/users/recent-logins', [NextcloudController::class, 'recentLogins']);

Route::get('/alerts/active', [AlertController::class, 'active']);
