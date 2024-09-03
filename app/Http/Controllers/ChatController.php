<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function viewChat()
    {
        return view('chat.chat');
    }
}
