<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function registerForm()
    {
        return view('register.form');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required', 'string', 'min:1'],
            'last_name' => ['required', 'string', 'min:1'],
            'username' => ['required', 'string', 'min:4', 'max:255', 'regex:/^\S*$/u'],
            'email' => ['required', 'unique:users', 'email'],
            'password' => ['required', 'min:5', 'confirmed'],
            'phone_number' => ['required', 'numeric']
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Insert data to database
        $user = User::create($validatedData);

        // Log the user in
        Auth::login($user);

        // Send email verification notification
        event(new Registered($user));

        return redirect()->route('verification.notice');
    }
}
