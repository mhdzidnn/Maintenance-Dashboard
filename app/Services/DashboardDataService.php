<?php

namespace App\Services;

use App\Models\Node;
use App\Models\StorageHealth;
use App\Models\VirtualMachine;
use App\Models\NextcloudStat;
use App\Models\NextcloudUser;
use App\Models\SystemAlert;
use Illuminate\Support\Facades\Cache;

class DashboardDataService
{
    public function getNodeHealth($id = null)
    {
        return Cache::remember('node_health_' . ($id ?? 'all'), 300, function () use ($id) {
            if ($id) {
                return Node::findOrFail($id);
            }
            return Node::all();
        });
    }

    public function getStorageHealth()
    {
        return Cache::remember('storage_health', 300, function () {
            return StorageHealth::with('node')->get();
        });
    }

    public function getTopVMs($limit = 5)
    {
        return Cache::remember('top_vms', 300, function () use ($limit) {
            return VirtualMachine::with('node')
                ->orderBy('usage_gb', 'desc')
                ->take($limit)
                ->get();
        });
    }

    public function getNextcloudOverview()
    {
        return Cache::remember('nextcloud_overview', 300, function () {
            return NextcloudStat::latest()->first();
        });
    }

    public function getNextcloudRecentLogins()
    {
        return Cache::remember('nextcloud_recent_logins', 300, function () {
            return NextcloudUser::orderBy('last_login', 'desc')->take(5)->get();
        });
    }

    public function getActiveAlerts()
    {
        return Cache::remember('active_alerts', 300, function () {
            return SystemAlert::where('is_resolved', false)->orderBy('created_at', 'desc')->get();
        });
    }
}
