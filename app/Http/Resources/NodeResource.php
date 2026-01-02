<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'uptime_days' => $this->uptime_days,
            'uptime_percentage' => (float) $this->uptime_percentage,
            'last_check' => $this->updated_at->diffForHumans(),
        ];
    }
}
