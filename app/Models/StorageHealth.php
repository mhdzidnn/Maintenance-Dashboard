<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorageHealth extends Model
{
    use HasFactory;

    protected $table = 'storage_health';

    protected $fillable = [
        'node_id',
        'name',
        'usage_percentage',
        'local_percentage',
        'raid_status',
        'trend',
        'alert_level'
    ];

    public function node()
    {
        return $this->belongsTo(Node::class);
    }
}
