<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NextcloudUserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'username' => $this->username,
            'quota_used_gb' => (float) $this->quota_used_gb,
            'quota_total_gb' => (float) $this->quota_total_gb,
            'quota_percentage' => $this->quota_total_gb > 0 ? round(($this->quota_used_gb / $this->quota_total_gb) * 100, 2) : 0,
            'last_login' => $this->last_login ? $this->last_login->diffForHumans() : 'Never',
        ];
    }
}
