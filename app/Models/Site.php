<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    protected $fillable = [
        'name',
        'key',
        'ip_node',
        'description',
    ];

    public function thresholdAlert()
    {
        return $this->hasOne(ThresholdAlert::class);
    }
}
