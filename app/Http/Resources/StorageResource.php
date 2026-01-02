<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StorageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'node_name' => $this->node->name,
            'name' => $this->name,
            'usage_percentage' => (float) $this->usage_percentage,
            'local_percentage' => (float) $this->local_percentage,
            'raid_status' => $this->raid_status,
            'trend' => $this->trend,
            'alert_level' => $this->alert_level,
        ];
    }
}
