<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\NextcloudUser;

class RecentLogins extends Component
{
    public $users;

    public function mount()
    {
        $this->users = NextcloudUser::orderBy('last_login', 'desc')
            ->take(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.recent-logins');
    }
}
