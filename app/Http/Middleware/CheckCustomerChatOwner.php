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
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the transaction ID from the route
        $chat = $request->route('chat');

        if($chat && $chat->user_id !== auth()->user()->id) {
            return redirect()->back()->with('error', 'You are not authorized to view this chat.');
        }

        return $next($request);
    }
}
