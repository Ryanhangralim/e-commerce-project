<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Return profile page for admin
    public function adminProfile()
    {
        $user = Auth::user();

        $data = [
            'user' => $user
        ];

        return view('profile.admin-profile', $data);
    }
}
