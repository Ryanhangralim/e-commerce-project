<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class PasswordController extends Controller
{
    // Reset password index
    public function forgotPasswordForm(){
        return view('auth.forgot-password');
    }

    // Validate email and send password reset request
    public function validateEmail(Request $request){
        // Validate email 
        $request->validate(['email' => 'required|email']);

        // Send password reset link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    public function resetPasswordForm(string $token){
        return view('auth.reset-password', ['token' => $token]);
    }

    public function resetPassword(Request $request){
        // Validate request
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|confirmed',
        ]);

        // Reset password
        $status = Password::reset(
        $request->only('email', 'password', 'password_confirmation', 'token'),
        function(User $user, string $password){
            $user->forceFill([
                'password' => Hash::make($password)
            ]);

            $user->save();

            event(new PasswordReset($user));
        }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('success', __($status))
                    : back()->withErrors(['email'=> [__($status)]]);
    }
}
