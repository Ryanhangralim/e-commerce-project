<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SebastianBergmann\Type\TrueType;

class OrderController extends Controller
{
    // Create checkout product
    public static function newOrder(Transaction $transaction, Cart $cart)
    {
        // Fetch related data
        $productCurrentPrice = calculateDiscount($cart->product);

        $orderData = [
            'transaction_id' => $transaction->id,
            'product_id' => $cart->product_id,
            'price' => $productCurrentPrice,
            'quantity' => $cart->quantity,
            'total_price' => $productCurrentPrice * $cart->quantity
        ];

        // Create order
        Order::create($orderData);
    }
}
