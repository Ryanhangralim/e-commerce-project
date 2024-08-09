<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $product_picture_path;
    
    // constructor
    public function __construct()
    {
        $this->product_picture_path = env('PRODUCT_PICTURE_PATH');
    }

    // Cart view
    public function viewCart()
    {
        $userCarts = Auth()->user()->carts
        ->load('product.business')
        ->groupBy('product.business_id');

        $data = [
            'carts' => $userCarts,
            'product_picture_path' => $this->product_picture_path
        ];

        return view('cart.cart', $data);
    }

    // Update quantity
    public function updateQuantity(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'cart_product_id' => ['required', 'integer', 'min:1', 'exists:carts,id'],
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        // Find the cart
        $cart = Cart::find($validatedData['cart_product_id']);

        // Update to new quantity
        $cart->quantity = $validatedData['quantity'];
        $cart->save();

        // Calculate new total price
        $newTotal = $cart->product->price * $cart->quantity;
        $newTotalFormatted = number_format($newTotal, 0, ',', '.');

        // Return JSON response
        return response()->json([
            'success' => true,
            'newTotalFormatted' => $newTotalFormatted
        ]);
    }
}
