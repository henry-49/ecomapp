<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthManager extends Controller
{
    
    function login()
    {
        // return a view for login
        return view('auth.login');
       
    }

    function loginPost(Request $request)
    {
        // Logic for handling post-login actions
        // Validate request, check credentials, etc.
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        $credentials = $request->only('email', 'password');

         // If successful, redirect user, set session, etc.
        if (Auth::attempt($credentials)) {
            return redirect()->intended(route('home')); // Redirect to intended page
        } else {
            return redirect('login')->with('error', 'Invalid Email or Password'); // Redirect back
        }
    }

    function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

   
    function register()
    {
        // return a view for registration
        return view('auth.register');
    }

    function registerPost(Request $request)
    {
        // Logic for handling user registration
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);
        
        // Validate request, create user, etc.
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);

        if($user->save()) {
           return redirect()->intended(route('login'))
                ->with('success', 'Registration successful. Please login.');
        }

        return redirect()->route('register')->with('error', 'Registration failed. Please try again.');
    }
}