<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
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
            'business' => $business 
        ];

        return view('dashboard.admin.business-detail', $data);
    }

    // business home page
    public function main(Business $business)
    {
        $data = [
            'business' => $business
        ];

        return view('business.main', $data);
    }

}
