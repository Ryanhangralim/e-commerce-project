<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReportController extends Controller
{
    // Generate user report
    public function generateUserReport(Request $request)
    {
        $today = date("Y-m-d H:i:s");

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
            'date' => $today
        ];

        $pdf = Pdf::loadview('report.user-report', $data);
        return $pdf->stream();
    }
}
