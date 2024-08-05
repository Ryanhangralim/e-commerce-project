<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class GenerateReportController extends Controller
{
    protected $today;

    public function __construct()
    {
        $this->today = date("Y-m-d H:i:s");
    }

    // Generate user report
    public function generateUserReport(Request $request)
    {
        $role_number = [
            'customer' => 1,
            'seller' => 2,
            'admin' => 3
        ];

        $role = $request->query('role', 'all');
        
        // Validate role
        $validRoles = ['all', 'customer', 'seller', 'admin'];
        if(!in_array($role, $validRoles)){
            $role = "all";
        }

        // Return data based on request
        if($role == 'all'){
            $users = User::all();
        } else{
            $users = User::where('role_id', $role_number[$role])->get();
        }

        $data = [
            'role' => $role,
            'users' => $users,
            'date' => $this->today
        ];

        $pdf = Pdf::loadview('report.user-report', $data);
        return $pdf->stream('User Report');
    }

    // Generate product report
    public function generateProductReport()
    {
        $data = [
            'products' => Auth::user()->products,
            'business' => Auth::user()->business,
            'date' => $this->today
        ];

        $pdf = Pdf::loadview('report.product-report', $data);
        return $pdf->stream('Product Report');
    }

    // Generate business report
    public function generateBusinessReport()
    {
        $data = [
            'date' => $this->today,
            'businesses' => Business::all()
        ];

        $pdf = Pdf::loadview('report.business-report', $data);
        return $pdf->stream('Business Report');
    }

    // Generate business report
    public function generateBusinessDetailReport(Business $business)
    {
        $data = [
            'date' => $this->today,
            'business' => $business
        ];

        $pdf = Pdf::loadview('report.business-detail-report', $data);
        return $pdf->stream('Business Detail Report');
    }
}
