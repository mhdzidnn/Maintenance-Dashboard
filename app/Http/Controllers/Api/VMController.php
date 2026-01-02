<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VMResource;
use App\Services\DashboardDataService;

class VMController extends Controller
{
    protected $service;

    public function __construct(DashboardDataService $service)
    {
        $this->service = $service;
    }

    public function topUsage()
    {
        $vms = $this->service->getTopVMs();
        return VMResource::collection($vms);
    }
}
