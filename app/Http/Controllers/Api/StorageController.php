<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StorageResource;
use App\Services\DashboardDataService;

class StorageController extends Controller
{
    protected $service;

    public function __construct(DashboardDataService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $storage = $this->service->getStorageHealth();
        return StorageResource::collection($storage);
    }
}
