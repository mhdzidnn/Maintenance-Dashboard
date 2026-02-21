<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function lokasiProxmox()
    {
        return view('master-data.lokasi-proxmox');
    }

    public function thresholdAlert()
    {
        return view('master-data.threshold-alert');
    }
}
