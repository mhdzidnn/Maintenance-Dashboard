<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Node;
use App\Models\VirtualMachine;

class VMUsageCard extends Component
{
    public $vms;

    public function mount()
    {
        $this->vms = VirtualMachine::with('node')
            ->orderBy('usage_gb', 'desc')
            ->take(3)
            ->get();
    }

    public function render()
    {
        return view('livewire.v-m-usage-card');
    }
}
