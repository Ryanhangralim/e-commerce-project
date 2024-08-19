<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    protected $product_picture_path;
    
    // constructor
    public function __construct()
    {
        $this->product_picture_path = env('PRODUCT_PICTURE_PATH');
    }

    // View transaction
    public function viewTransactions(Request $request)
    {
        // Get transaction type from query parameter, default to all
        $type = $request->query('type', 'all');

        // Build the base query for the transactions
        $query = Transaction::where('user_id', Auth::user()->id)
            ->orderBy('updated_at', 'desc');

        // Filter by the status type if provided and not 'all'
        if ($type !== 'all') {
            $query->where('status', $type);
        }

        // Get the filtered transactions
        $transactions = $query->get();
        $transaction_count = $this->getTransactionCount();
        $transaction_count['all'] = count($transactions);

        // Pass the transactions and the current type to the view
        $data = [
            'transactions' => $transactions,
            'currentType' => $type,
            'transaction_count' => $transaction_count,
            'product_picture_path' => $this->product_picture_path
        ];

        return view('transaction.transaction', $data);
    }

    // Get transaction count for every type
    public function getTransactionCount()
    {
            // Define the statuses you want to count
            $statuses = ['pending', 'processing', 'delivered', 'received', 'completed', 'canceled'];

            // Initialize an associative array to store the counts
            $transactionCounts = [];

            // Loop through each status and get the count of transactions for the authenticated user
            foreach ($statuses as $status) {
                $transactionCounts[$status] = Transaction::where('user_id', Auth::user()->id)
                    ->where('status', $status)
                    ->count();
            }

            return $transactionCounts;
    }

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
