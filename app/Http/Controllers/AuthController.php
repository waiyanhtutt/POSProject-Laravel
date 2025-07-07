<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // direct login page
    public function dologin()
    {
        return view('login');
    }

    // direct register page
    public function doregister()
    {
        return view('register');
    }

    // direct dashboard
    public function dashboard()
    {
        if (Auth::user()->role === "admin") {
            return redirect()->route('category#list');
        } elseif (Auth::user()->role === "user") {
            return redirect()->route('user#home');
        }

        return redirect()->route('dashboard');
    }
}
