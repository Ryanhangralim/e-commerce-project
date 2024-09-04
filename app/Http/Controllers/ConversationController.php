<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Conversation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function newConversation(Request $request, Chat $chat)
    {
        $validatedData = $request->validate([
            "message" => ['required', 'min:1', 'max:500']
        ]);

        $validatedData["sender"] = Auth::user()->role->title;
        $validatedData["chat_id"] = $chat->id;

        // create new conversation
        Conversation::create($validatedData);

        // update the chat updated at
        $chat->touch();

        return redirect()->back();
    }
}
