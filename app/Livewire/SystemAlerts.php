<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\SystemAlert;

class SystemAlerts extends Component
{
    public $alerts;

    public function mount()
    {
        $this->alerts = SystemAlert::where('is_resolved', false)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function resolve($id)
    {
        $alert = SystemAlert::find($id);
        if ($alert) {
            $alert->update(['is_resolved' => true]);
            $this->alerts = SystemAlert::where('is_resolved', false)
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.system-alerts');
    }
}
