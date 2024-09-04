<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    // ChatController.php
    public function viewChat($chatId)
    {
        $user = Auth::user();

        $chat = $chatId;
        $chats = $user->business ? Chat::where('business_id', $user->business->id)->get() : Auth::user()->chats;

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
        $user = Auth::user();
        $chats = $user->business ? Chat::where('business_id', $user->business->id)->get() : Auth::user()->chats;

        $data = [
            "chats" => $chats
        ];

        return view('chat.chat', $data);
    }

    public function newChat(Request $request)
    {
        $userID = Auth::user()->id;
        $chatExists = Chat::where('user_id', $userID)
                              ->where('business_id', $request['business_id'])
                              ->first();

        if( $chatExists )
        {
            return redirect()->route('chat', ['chat' => $chatExists->id]);
        } else {
            $newChat = Chat::create([
                "user_id" => $userID,
                "business_id" => $request["business_id"]
            ]);

            return redirect()->route('chat', ['chat' => $newChat->id]);
        }
    }

    public function deleteChat(Chat $chat)
    {
        $chat->delete();
        return redirect()->route('chat.list')->with('success', 'Chat deleted');
    }

}
