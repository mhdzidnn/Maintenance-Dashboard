<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProxmoxVm extends Model
{

    protected $fillable = [
        'vm_id',
        'proxmox_node_id',
        'name',
        'type',
        'status',
        'os_type',
        'cpu_cores',
        'memory_total_gb',
        'disk_total_gb',
        'ip_address',
        'cpu_usage_percent',
        'memory_usage_percent',
        'disk_usage_gb',
        'formatted_uptime',
        'last_synced_at',
    ];

    protected $casts = [
        'last_synced_at' => 'datetime',
    ];

    public function node()
    {
        return $this->belongsTo(ProxmoxNode::class, 'proxmox_node_id');
    }
}
