<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ThresholdAlert extends Model
{
    protected $fillable = [
        'site_id',
        'cpu_limit',
        'mem_limit',
        'disk_limit',
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }
}
