<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AlertResource;
use App\Services\DashboardDataService;

class AlertController extends Controller
{
    protected $service;

    public function __construct(DashboardDataService $service)
    {
        $this->service = $service;
    }

    public function active()
    {
        $alerts = $this->service->getActiveAlerts();
        return AlertResource::collection($alerts);
    }
}
