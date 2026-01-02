<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NextcloudUser;

class UserQuotaWarning extends Component
{
    public $users;

    public function mount()
    {
        $this->users = NextcloudUser::whereRaw('(quota_used_gb / quota_total_gb) >= 0.8')
            ->orderByRaw('(quota_used_gb / quota_total_gb) DESC')
            ->take(2)
            ->get();
    }

    public function render()
    {
        return view('livewire.user-quota-warning');
    }
}
