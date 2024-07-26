<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // User table page
    public function index()
    {
        $users = User::all();

        $data = [
            'users' => $users
        ];

        return view('dashboard.user', $data);
    }
}
