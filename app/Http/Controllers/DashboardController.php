<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Business;
use App\Models\Category;
use App\Models\SellerApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    // view dashboard
    public function adminDashboard()
    {
        $data = [
            'user_count' => User::count(),
            'business_count' => Business::count(),
            'pending_application_count' => SellerApplication::where('application_status', 'pending')->count(),
            'category_count' => Category::count()
        ];

        return view('dashboard.admin.dashboard', $data);
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
