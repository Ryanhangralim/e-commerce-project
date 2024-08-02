<?php

namespace App\Http\Middleware;

use App\Models\Product;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckBusinessOwner
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Retrieve the product ID from the route
        $product = $request->route('product');
        // dd($product->business->user_id);

        if($product && $product->business->user_id !== auth()->user()->id) {
            return redirect()->route('view-product')->with('error', 'You are not authorized to view this product.');
        }

        return $next($request);
    }
}
