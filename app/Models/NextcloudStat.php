<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextcloudStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'status',
        'total_users',
        'storage_used_tb',
        'storage_total_tb'
    ];
}
