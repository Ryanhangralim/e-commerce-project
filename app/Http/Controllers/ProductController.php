<?php

namespace App\Http\Controllers;

use App\Models\Product;
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

        return view('dashboard.seller.product.product', $data);
    }

    // View product detail
    public function productDetail(Product $product)
    {
        $data = [
            'product' => $product
        ];

        return view('dashboard.seller.product.product-detail', $data);
    }

    // Add product stock
    public function addStock(Product $product, Request $request)
    {
        $request->validate([
            'numberOfProducts' => ['required', 'min:1', 'integer']
        ]);

        // Update stock
        $product->stock += (int) $request->numberOfProducts; 
        $product->save();

        return redirect()->back()->with('success', 'Stock successfully added!');
    }

    // Set product dicount
    public function setDiscount(Product $product, Request $request)
    {
        $request->validate([
            'discount' => ['required', 'min:0', 'integer', 'max:99']
        ]);

        // Update stock
        $product->discount = (int) $request->discount; 
        $product->save();

        return redirect()->back()->with('success', 'Discount successfully updated!');        
    }
}
