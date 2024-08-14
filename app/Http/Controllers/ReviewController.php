<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    // Add reply
    public function addReply(Request $request, Review $review)
    {
        if(isBusinessOwner($review->product->business->user_id))
        {
            $validatedData = $request->validate([
                'seller_reply' => ['required', 'min:1']
            ]);

            // save reply
            $review['seller_reply'] = $validatedData['seller_reply'];
            $review->save();

            return back()->with('success', 'Successfully Replied!');
        }
        else {
            return back()->with('error', 'You do not have access to reply');
        }
    }
}
