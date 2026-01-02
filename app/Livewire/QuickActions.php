<?php

namespace App\Livewire;

use Livewire\Component;

class QuickActions extends Component
{
    public $isProcessing = false;
    public $activeAction = null;

    public function runAction($name)
    {
        $this->isProcessing = true;
        $this->activeAction = $name;

        // Simulate logic
        sleep(1);

        $this->isProcessing = false;
        $this->activeAction = null;

        $this->dispatch('action-completed', ['message' => "$name operation completed successfully!"]);
    }

    public function render()
    {
        return view('livewire.quick-actions');
    }
}
