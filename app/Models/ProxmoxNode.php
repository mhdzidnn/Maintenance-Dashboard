<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProxmoxNode extends Model
{
    protected $fillable = [
        'name',
        'location',
        'ip_address',
        'status',
        'cpu_usage',
        'memory_usage',
        'disk_usage',
        'uptime',
    ];

    public function vms()
    {
        return $this->hasMany(ProxmoxVm::class);
    }
}
