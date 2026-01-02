<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NextcloudUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'username',
        'quota_used_gb',
        'quota_total_gb',
        'last_login'
    ];

    protected $casts = [
        'last_login' => 'datetime',
    ];
}
