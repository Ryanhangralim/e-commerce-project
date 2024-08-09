<?php

namespace App\Http\Controllers;

use App\Models\Business;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class BusinessProfileController extends Controller
{
    protected $business_profile_path;
    
    // constructor
    public function __construct()
    {
        $this->business_profile_path = env('BUSINESS_PROFILE_PATH');
    }

    // business profile view
    public function viewBusinessProfile()
    {
        $business = Auth::user()->business;

        $data = [
            'business' => $business,
            'business_profile_path' => $this->business_profile_path
        ];

        return view('business.business-profile', $data);
    }

    // Update business profile picture
    public function updateBusinessProfilePicture(Request $request)
    {
        // Get old business profile picture
        $business = Auth::user()->business;
        $oldProfilePicture = $business->image;
        $oldProfilePicturePath = public_path($this->business_profile_path . $oldProfilePicture);

        // Create new image manager
        $manager = new ImageManager(new Driver());

        // Validate user input
        $request->validate([
            'business_profile_picture' => ['image', 'mimes:jpeg,png', 'max:1024']
        ]);

        // Process/save image
        if ($request->hasFile('business_profile_picture')) {
            $image = $request->file('business_profile_picture');
            $file_name = $business->slug . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path($this->business_profile_path . $file_name); 

            // Delete old profile picture if exist
            if($oldProfilePicture && File::exists($oldProfilePicturePath)){
                File::delete($oldProfilePicturePath);
            }

            // Save new profile picture
            $manager->read($image->getPathname())->resize(300, 300)->save($path);
    
            // Update profile picture
            $business->update(['image' => $file_name]);

            return redirect()->route('business-profile.view')->with('success', 'Business Profile picture updated');
        }

        return redirect()->back();
    }
}
