<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class LandingController extends Controller
{
    protected $business_profile_path, $product_picture_path;

    // constructor
    public function __construct()
    {
        $this->product_picture_path = env('PRODUCT_PICTURE_PATH');
    }

    // Return landing page
    public function landing(Request $request)
    {
        if($request['search'])
        {
            $products = Product::latest()->filter(request(['search']))->paginate(24);   
        } else {
            $products = Product::inRandomOrder() // Orders by the review count
            ->paginate(24);
        }        

        $data = [
            'products' => $products,
            'product_picture_path' => $this->product_picture_path
        ];

        return view('landing.landing', $data);
    }
}
