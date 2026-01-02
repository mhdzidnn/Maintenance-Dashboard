<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NextcloudResource;
use App\Http\Resources\NextcloudUserResource;
use App\Services\DashboardDataService;

class NextcloudController extends Controller
{
    protected $service;

    public function __construct(DashboardDataService $service)
    {
        $this->service = $service;
    }

    public function overview()
    {
        $stats = $this->service->getNextcloudOverview();
        return new NextcloudResource($stats);
    }

    public function recentLogins()
    {
        $users = $this->service->getNextcloudRecentLogins();
        return NextcloudUserResource::collection($users);
    }
}
