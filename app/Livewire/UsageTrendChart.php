<?php

namespace App\Livewire;

use Livewire\Component;

class UsageTrendChart extends Component
{
    public $labels = [];
    public $usageData = [];

    public function mount()
    {
        // Temapat mengambil data nyata dari database
        // $stats = \App\Models\NextcloudStat::latest()->take(7)->get()->reverse();
        
        // if ($stats->count() > 0) {
        //     $this->labels = $stats->pluck('created_at')->map(fn($d) => $d->format('H:i'))->toArray();
        //     $this->usageData = $stats->pluck('usage_percent')->toArray();
        // } else {
            // Fallback Dummy Data
            $this->labels = ['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7'];
            $this->usageData = [65.2, 68.4, 70.1, 72.5, 71.8, 74.2, 75.5];
        // }
    }
}
