<?php

namespace App\Livewire;

use Livewire\Component;

class UsageTrendChart extends Component
{
    public $labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
    public $usageData = [65.2, 68.4, 70.1, 72.5, 71.8, 74.2, 75.5];

    public function render()
    {
        return view('livewire.usage-trend-chart');
    }
}
