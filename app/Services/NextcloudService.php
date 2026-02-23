<?php

namespace App\Services;

use App\Models\NextcloudStat;
use App\Models\NextcloudUser;

class NextcloudService
{
    public function getStats()
    {
        // TODO: Ganti dengan call API real.
        return NextcloudStat::latest()->first();
    }

    public function getUsers()
    {
        // TODO: Ganti dengan call API real.
        return NextcloudUser::all();
    }
}
