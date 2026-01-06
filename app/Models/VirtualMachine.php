<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualMachine extends Model
{
    use HasFactory;

    protected $fillable = [
        'node_id',
        'vm_id',
        'name',
        'usage_gb',
        'cpu_cores',
        'cpu_usage_percent',
        'memory_total_mb',
        'memory_used_mb',
        'memory_usage_percent',
        'uptime_seconds',
        'is_running',
        'status',
        'os_type',
        'last_synced_at'
    ];

    protected $casts = [
        'is_running' => 'boolean',
        'cpu_usage_percent' => 'decimal:2',
        'memory_usage_percent' => 'decimal:2',
        'last_synced_at' => 'datetime'
    ];

    public function node()
    {
        return $this->belongsTo(Node::class);
    }

    /**
     * Get formatted uptime
     */
    public function getFormattedUptimeAttribute()
    {
        if (!$this->uptime_seconds) {
            return 'N/A';
        }

        $days = floor($this->uptime_seconds / 86400);
        $hours = floor(($this->uptime_seconds % 86400) / 3600);
        $minutes = floor(($this->uptime_seconds % 3600) / 60);

        if ($days > 0) {
            return "{$days} days {$hours}:{$minutes}:00";
        }
        return "{$hours}:{$minutes}:00";
    }

    /**
     * Get formatted memory used
     */
    public function getFormattedMemoryAttribute()
    {
        $usedGb = number_format($this->memory_used_mb / 1024, 2);
        $totalGb = number_format($this->memory_total_mb / 1024, 2);
        return "{$usedGb} GiB of {$totalGb} GiB";
    }
}
