<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Node;

class NodeSeeder extends Seeder
{
    public function run(): void
    {
        Node::create([
            'name' => 'prox01',
            'status' => 'healthy',
            'uptime_days' => 47,
            'uptime_percentage' => 0.32,
        ]);

        Node::create([
            'name' => 'prox02',
            'status' => 'warning',
            'uptime_days' => 45,
            'uptime_percentage' => 98.50,
        ]);
    }
}
