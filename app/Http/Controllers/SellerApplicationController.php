<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SellerApplication;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerApplicationReceived;

class SellerApplicationController extends Controller
{
    // form
    public function index()
    {
        // Check if there is existing pending application
        $existingApplication = SellerApplication::where('user_id', Auth::id())
        ->where('application_status', 'pending')
        ->first();

        if($existingApplication) {
            return redirect()->back()->withErrors(['You already have a pending application']);
        };
        return view('seller-application.index');
    }

    // store application data
    public function store(Request $request)
    {
        $user = Auth::user();
        $validatedData = $request->validate([
            'business_name' => ['required', 'min:3', 'max:50'],
            'business_description' => ['required', 'min:10', 'unique:seller_applications']
        ]);

        // Hash password
        $validatedData['user_id'] = Auth::id();

        // Insert data to database
        $application = SellerApplication::create($validatedData);
        Mail::to($user->email)->send(new SellerApplicationReceived($user, $application));

        return redirect()->intended(route('home'))->with('status', 'Successfully applied');
    }
}
