<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Node extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'status', 'uptime_days', 'uptime_percentage'];

    public function storageHealth()
    {
        return $this->hasMany(StorageHealth::class);
    }

    public function virtualMachines()
    {
        return $this->hasMany(VirtualMachine::class);
    }
}
