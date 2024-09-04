<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCustomerChatOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Retrieve the chat model from the route parameter
        $chat = $request->route('chat');
    
        // Check if the chat exists and the authenticated user is either the chat owner or the business owner
        if ($chat) {
            $user = auth()->user();
            $isUserOwner = $chat->user_id === $user->id;
            $isBusinessOwner = $user->business && $chat->business_id === $user->business->id;
    
            if (!$isUserOwner && !$isBusinessOwner) {
                return redirect()->route('chat.list')->with('error', 'You are not authorized to view this chat.');
            }
        } else {
            // Handle the case where chat does not exist
            return redirect()->route('chat.list')->with('error', 'Chat not found.');
        }
    
        return $next($request);
    }
    
}
