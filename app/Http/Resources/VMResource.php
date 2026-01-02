<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VMResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'node_name' => $this->node->name,
            'vm_id' => $this->vm_id,
            'name' => $this->name,
            'usage_gb' => $this->usage_gb,
            'is_running' => (bool) $this->is_running,
        ];
    }
}
