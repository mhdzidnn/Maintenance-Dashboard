<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Node;

class NodeStatusCard extends Component
{
    public $node;

    public function mount($nodeId)
    {
        $this->node = Node::find($nodeId);
    }

    public function render()
    {
        return view('livewire.node-status-card');
    }
}
