<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class DashboardController extends Controller
{
    // Admin dashboard
    public function adminDashboard()
    {
        return view('dashboard.admin-dashboard');
    }
}
