<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxmoxController extends Controller
{
    public function index() { return view('proxmox.index'); }
    public function nodes() 
    { 
        $vms = \App\Models\VirtualMachine::with('node')->get();
        return view('proxmox.nodes', compact('vms')); 
    }
    public function storage() { return view('proxmox.storage'); }
    public function vms() { return view('proxmox.vms'); }
    public function memory() { return view('proxmox.memory'); }
}
