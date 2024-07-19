<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'first_name' => ['required'],
            'last_name' => ['required'],
            'email' => ['required', 'unique:users'],
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
