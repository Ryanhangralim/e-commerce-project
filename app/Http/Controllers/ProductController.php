<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    // View product
    public function viewProduct()
    {
        return view('dashboard.seller.product');
    }
}
