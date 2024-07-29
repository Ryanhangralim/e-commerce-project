<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //Admin view
    public function view()
    {
        $businesses = Business::all();

        $data = [
            'businesses' => $businesses,
        ];

        return view('dashboard.business', $data);
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
