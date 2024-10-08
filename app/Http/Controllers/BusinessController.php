<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected $business_profile_path, $product_picture_path;
    
    // constructor
    public function __construct()
    {
        $this->business_profile_path = env('BUSINESS_PROFILE_PATH');
        $this->product_picture_path = env('PRODUCT_PICTURE_PATH');
    }

    //Admin view
    public function viewBusiness()
    {
        $businesses = Business::all();

        $data = [
            'businesses' => $businesses,
        ];

        return view('dashboard.admin.business', $data);
    }
    
    // view business details
    public function viewBusinessDetail(Business $business)
    {
        $data = [
            'business' => $business,
            'product_picture_path' => $this->product_picture_path 
        ];

        return view('dashboard.admin.business-detail', $data);
    }

    // business home page
    public function main(Business $business, Request $request)
    {
        if($request->query('business-search'))
        {
            $products = $business->products()->filterBusiness(request(['business-search']))->paginate(12);   
        } else {
            $products = $business->products()
                ->withCount('reviews') // Adds a 'reviews_count' column to the results
                ->orderBy('reviews_count', 'desc') // Orders by the review count
                ->paginate(12);
        }    

        $data = [
            'business' => $business,
            'products' => $products,
            'business_profile_path' => $this->business_profile_path,
            'product_picture_path' => $this->product_picture_path,
        ];

        return view('business.business', $data);
    }

}
