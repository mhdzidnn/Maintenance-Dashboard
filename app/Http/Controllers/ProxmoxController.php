<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProxmoxController extends Controller
{
    public function index() { return view('proxmox.index'); }
    public function nodes() { return view('proxmox.nodes'); }
    public function storage() { return view('proxmox.storage'); }
    public function vms() { return view('proxmox.vms'); }
    public function memory() { return view('proxmox.memory'); }
}
