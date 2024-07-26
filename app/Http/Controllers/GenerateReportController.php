<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class GenerateReportController extends Controller
{
    // Generate user report
    public function generateUserReport()
    {
        $users = User::all();
        $today = date("Y-m-d H:i:s");

        $data = [
            'users' => $users,
            'date' => $today
        ];

        $pdf = Pdf::loadview('report.user-report', $data);
        return $pdf->stream();
    }
}
