<?php

namespace App\Http\Controllers;

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
}
