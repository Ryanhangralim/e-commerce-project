<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    // Add Product to cart
    public function addProduct(Request $request, Product $product)
    {
        $product_id = $product->id;
        $user_id = Auth()->user()->id;

        // Validate quantity input
        $validatedData = $request->validate([
            'quantity' => ['required', 'integer', 'min:1']
        ]);

        // Check stock
        if($validatedData['quantity'] > $product->stock)
        {
            return back()->with('error', 'Stock unavailable');
        }

        // Add additional information
        $validatedData['user_id'] = $user_id;
        $validatedData['product_id'] = $product_id;
        
        // Check if product is in cart
        if($existing_cart = Cart::where('user_id', $user_id)
               ->where('product_Id', $product_id)
               ->first()){
                if($validatedData['quantity'] + $existing_cart->quantity > $product->stock)
                {
                    return back()->with('error', 'Stock unavailable');     
                }
            $existing_cart->quantity += $validatedData['quantity'];
            $existing_cart->save();
        } else {
            // Add product to cart
            Cart::create($validatedData);
        }

        return back()->with('success', $product->name . 'Successfully Added!');
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
        $newTotal = calculateDiscount($cart->product) * $cart->quantity;
        $newTotalFormatted = formatNumber($newTotal);

        // Return JSON response
        return response()->json([
            'success' => true,
            'newTotalFormatted' => $newTotalFormatted
        ]);
    }

    // delete product function
    public function deleteProduct(Request $request)
    {
        $validatedData = $request->validate([
            'cart_product_id' => ['required', 'integer', 'exists:carts,id']
        ]);
    
        $cart = Cart::find($validatedData['cart_product_id']);
        if ($cart) {
            $cart->delete();
            return response()->json([
                'success' => true,
                'count' => count(Auth()->user()->carts)
            ]);
        }
    
        return response()->json(['success' => false]);

    }
}
