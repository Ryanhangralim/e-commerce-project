<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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

        //masukkan data ke database
        User::create($validatedData);

        return redirect(route('login'))->with('success', 'Successfully Registered!');
    }
}
