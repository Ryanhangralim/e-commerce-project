<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ChatController.php
    public function viewChat($chatId)
    {
        $chat = $chatId;
        $chats = Auth::user()->chats; // Or use the existing logic to retrieve the chat list

        if ($chat) {
            $data = [
                "chat" => $chat,
                "chats" => $chats,
                "currentChat" => $chat->id
            ];

            return view('chat.show', $data);
        }

        return redirect()->route('chat', Auth::user()->latestChatId)->with('error', 'Chat not found');
    }

    public function show()
    {
        return redirect()->route('chat', Auth::user()->latestChatId);
    }

}
