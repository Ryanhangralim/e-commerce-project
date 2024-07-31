<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Return profile page for admin
    public function viewProfile()
    {
        $user = Auth::user();

        $data = [
            'user' => $user
        ];

        return view('profile.profile', $data);
    }
}
