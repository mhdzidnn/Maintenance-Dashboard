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
        'is_running'
    ];

    public function node()
    {
        return $this->belongsTo(Node::class);
    }
}
