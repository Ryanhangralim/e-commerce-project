<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class MailController extends Controller
{
    // Email verification notice function
    public function verificationNotice(){
        return view('auth.verify-email');
    }

    // Email verification handler
    public function verificationHandler(EmailVerificationRequest $request){
        // call markEmailAsVerified method 
        $request->fulfill();

        return redirect()->route('home');
    }

    // Resend email verification
    public function resendVerificationEmail(Request $request){
        $request->user()->sendEmailVerificationNotification();
        
        return back()->with('status', 'verification-link-sent');
    }
}
