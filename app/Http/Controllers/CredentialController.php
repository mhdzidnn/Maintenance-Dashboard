<?php

namespace App\Http\Controllers;

use App\Models\Credential;
use Illuminate\Http\Request;

class CredentialController extends Controller
{
    public function index($ip)
    {
        return view('credentials.index', compact('ip'));
    }

    public function getCredentials($ip)
    {
        $credentials = Credential::where('server_ip', $ip)->get();
        return response()->json($credentials);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'server_ip' => 'required|string',
            'name'      => 'required|string',
            'username'  => 'required|string',
            'email'     => 'nullable|email',
            'password'  => 'required|string',
        ]);

        $credential = Credential::updateOrCreate(
            ['id' => $request->id],
            $data
        );

        return response()->json($credential);
    }

    public function destroy($id)
    {
        Credential::destroy($id);
        return response()->json(['success' => true]);
    }
}
