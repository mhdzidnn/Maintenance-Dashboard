<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if ($credentials['username'] === 'admin' && $credentials['password'] === 'password') {
            session([
                'is_logged_in' => true,
                'user_name' => 'Admin'
            ]);
            return redirect()->route('dashboard');
        }

        return back()->with('error', 'Invalid username or password.');
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login');
    }
}
