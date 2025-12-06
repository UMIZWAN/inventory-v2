<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show login view
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/admin/dashboard');
        }
        return view('auth.login');
    }

    // Handle login request
    public function login(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    // Attempt login using username
    if (Auth::attempt($request->only('username', 'password'))) {
        return redirect('/admin/dashboard'); // redirect after successful login
    }

    return back()->withErrors([
        'username' => 'Invalid credentials.',
    ]);
}


    // Handle logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/admin/login');
    }
}
