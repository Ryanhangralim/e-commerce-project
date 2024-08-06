<?php

namespace App\Http\Controllers;

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
    public function main(Business $business)
    {
        $data = [
            'business' => $business,
            'business_profile_path' => $this->business_profile_path,
            'product_picture_path' => $this->product_picture_path
        ];

        return view('business.main', $data);
    }

}
