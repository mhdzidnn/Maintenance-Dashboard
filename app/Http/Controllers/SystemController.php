<?php

namespace App\Http\Controllers;

class SystemController extends Controller
{
    public function index()
    {
        return view('system.index');
    }

    public function alerts()
    {
        return view('system.alerts');
    }

    public function logs()
    {
        return view('system.logs');
    }
}
