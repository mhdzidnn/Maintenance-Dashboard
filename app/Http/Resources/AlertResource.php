<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AlertResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'title' => $this->title,
            'message' => $this->message,
            'details' => $this->details,
            'is_resolved' => (bool) $this->is_resolved,
            'created_at' => $this->created_at->toDateTimeString(),
            'time_ago' => $this->created_at->diffForHumans(),
        ];
    }
}
