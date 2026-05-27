<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function login()
    {
        Log::debug("============= UserController: Start Login ================");
        return view('login');
    }

    public function store(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {

            // Block customers from logging in
            if (auth()->user()->role === 'customer') {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Customers are not allowed to log in.',
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            Log::info("Login success: " . $request->email);
            return redirect()->route('home');
        }

        Log::warning("Login failed: " . $request->email);
        return back()->withErrors([
            'email' => 'Invalid email or password.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Log::debug("============= UserController: Logout ================");
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
