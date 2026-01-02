<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\VirtualMachine;
use App\Models\Node;

class VirtualMachineSeeder extends Seeder
{
    public function run(): void
    {
        $prox01 = Node::where('name', 'prox01')->first();

        VirtualMachine::create([
            'node_id' => $prox01->id,
            'vm_id' => 'VM 110',
            'name' => 'Backup',
            'usage_gb' => 450,
            'is_running' => true,
        ]);

        VirtualMachine::create([
            'node_id' => $prox01->id,
            'vm_id' => 'VM 105',
            'name' => 'DB Server',
            'usage_gb' => 300,
            'is_running' => true,
        ]);

        VirtualMachine::create([
            'node_id' => $prox01->id,
            'vm_id' => 'VM 101',
            'name' => 'Web Server',
            'usage_gb' => 120,
            'is_running' => true,
        ]);
    }
}
