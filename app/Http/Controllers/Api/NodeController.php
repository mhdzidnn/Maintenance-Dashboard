<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NodeResource;
use App\Services\DashboardDataService;

class NodeController extends Controller
{
    protected $service;

    public function __construct(DashboardDataService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $nodes = $this->service->getNodeHealth();
        return NodeResource::collection($nodes);
    }

    public function show($id)
    {
        $node = $this->service->getNodeHealth($id);
        return new NodeResource($node);
    }
}
