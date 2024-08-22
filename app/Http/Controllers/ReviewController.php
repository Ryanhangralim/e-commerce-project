<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    // Add reply
    public function addReply(Request $request, Review $review)
    {
        if(isBusinessOwner($review->product->business->user_id))
        {
            $validatedData = $request->validate([
                'seller_reply' => ['required', 'min:5']
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

    // Add review
    public function addReview(Request $request)
    {
        // Check if there is content in review
        if($request->content){
            $validatedData = $request->validate([
                'rating' => ['Required', 'min:1', 'max:5', 'integer'],
                'content' => ['min:5']
            ]);
        } else {
            $validatedData = $request->validate([
                'rating' => ['Required', 'min:1', 'max:5', 'integer'],
            ]);
        }

        $validatedData['user_id'] = Auth::user()->id;
        $validatedData['order_id'] = $request['order_id'];
        $validatedData['product_id'] = $request['product_id'];

        // Add review
        Review::create($validatedData);

        return redirect()->back()->with('success', 'Review Added!');
    }
}
