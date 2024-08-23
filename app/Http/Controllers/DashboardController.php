<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    // view dashboard
    public function adminDashboard()
    {
        return view('dashboard.admin.dashboard');
    }

    public function sellerDashboard()
    {
        $business = Auth::user()->business;

        $data = [
            'business' => $business,
        ];

        return view('dashboard.seller.dashboard', $data);
    }

}
