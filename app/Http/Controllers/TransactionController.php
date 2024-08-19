<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Checkout function
    public function checkout(Request $request)
    {
        // Fetch products
        $selectedProductCartIds = $request['selected_products'];
        // Find product
        $selectedProductCarts = Cart::whereIn('id', $selectedProductCartIds)->get();
        
        // Create Transaction
        $transactionData['user_id'] = Auth()->user()->id;
        $transactionData['status'] = 'pending';
        $transactionData['business_id'] = $request['business_id'];
        $transaction = Transaction::create($transactionData);

        // Create order for each product
        foreach( $selectedProductCarts as $productCart)
        {
            OrderController::newOrder($transaction, $productCart);
        }

        return redirect()->route('home');
    }
}
