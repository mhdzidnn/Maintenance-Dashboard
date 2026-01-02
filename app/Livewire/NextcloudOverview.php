<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NextcloudStat;

class NextcloudOverview extends Component
{
    public $stats;

    public function mount()
    {
        $this->stats = NextcloudStat::latest()->first();
    }

    public function render()
    {
        return view('livewire.nextcloud-overview');
    }
}
