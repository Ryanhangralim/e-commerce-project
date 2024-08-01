<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    // View product
    public function viewProduct()
    {
        // Ensure the user has a business
        if ($business = Auth::user()->business) {
            // Retrieve the products of the user's business
            $products = $business->products;
        } else {
            // Handle the case where the user does not have a business
            $products = collect(); // Empty collection
        }

        $data = [
            'products' => $products,
        ];

        return view('dashboard.seller.product', $data);
    }
}
