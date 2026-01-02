<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NextcloudResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'status' => $this->status,
            'total_users' => $this->total_users,
            'storage_used_tb' => (float) $this->storage_used_tb,
            'storage_total_tb' => (float) $this->storage_total_tb,
            'usage_percentage' => $this->storage_total_tb > 0 ? round(($this->storage_used_tb / $this->storage_total_tb) * 100, 2) : 0,
        ];
    }
}
