<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function lokasiProxmox()
    {
        return view('master-data.lokasi-proxmox');
    }

    public function getLokasi()
    {
        return response()->json(\App\Models\Site::all());
    }

    public function storeLokasi(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'key' => 'required|string|unique:sites,key,' . $request->id,
            'ip_node' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $site = \App\Models\Site::updateOrCreate(['id' => $request->id], $data);
        
        // Ensure threshold exists for new site
        if (!$site->thresholdAlert) {
            $site->thresholdAlert()->create([
                'cpu_limit' => 80,
                'mem_limit' => 80,
                'disk_limit' => 80,
            ]);
        }

        return response()->json($site);
    }

    public function deleteLokasi($id)
    {
        \App\Models\Site::destroy($id);
        return response()->json(['success' => true]);
    }

    public function thresholdAlert()
    {
        $sites = \App\Models\Site::with('thresholdAlert')->get();
        return view('master-data.threshold-alert', compact('sites'));
    }

    public function updateThreshold(Request $request)
    {
        $data = $request->validate([
            'site_id' => 'required|exists:sites,id',
            'cpu_limit' => 'required|integer|min:0|max:100',
            'mem_limit' => 'required|integer|min:0|max:100',
            'disk_limit' => 'required|integer|min:0|max:100',
        ]);

        $threshold = \App\Models\ThresholdAlert::updateOrCreate(
            ['site_id' => $data['site_id']],
            $data
        );

        return response()->json($threshold);
    }
}
