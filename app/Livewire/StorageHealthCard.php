<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\StorageHealth;

class StorageHealthCard extends Component
{
    public $storage;

    public function mount($storageId)
    {
        $this->storage = StorageHealth::find($storageId);
    }

    public function render()
    {
        return view('livewire.storage-health-card');
    }
}
