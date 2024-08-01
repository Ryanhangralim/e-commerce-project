<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // login page
    public function loginForm(){
        return view('login.form');
    }

    // Authenticate 
    public function authenticate(Request $request){
        $validatedData = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:5']
        ]);

        $user = User::where('email', $validatedData['email']);

        if (!$user) {
            return back()->withErrors('failed', 'Wrong email or password!');
        }

        if (Auth::attempt(['email' => $validatedData['email'], 'password' => $validatedData['password']])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        } else {
            return back()->withErrors('failed', 'Wrong email or password!');
        }
    }
}
