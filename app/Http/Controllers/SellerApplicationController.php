<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellerApplicationController extends Controller
{
    // form
    public function index()
    {
        return view('seller-application.index');
    }
}
