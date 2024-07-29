<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    //Default view
    public function view()
    {
        $businesses = Business::all();

        $data = [
            'businesses' => $businesses,
        ];

        return view('dashboard.business', $data);
    }
}
