<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title',
        'message',
        'details',
        'is_resolved'
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];
}
