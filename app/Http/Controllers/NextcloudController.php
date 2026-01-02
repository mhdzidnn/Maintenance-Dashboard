<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NextcloudController extends Controller
{
    public function index() { return view('nextcloud.index'); }
    public function overview() { return view('nextcloud.overview'); }
    public function users() { return view('nextcloud.users'); }
    public function storage() { return view('nextcloud.storage'); }
}
