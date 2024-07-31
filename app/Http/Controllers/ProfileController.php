<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Svg\Gradient\Stop;

class ProfileController extends Controller
{
    // Return profile page for admin
    public function viewProfile()
    {
        $user = Auth::user();

        $data = [
            'user' => $user
        ];

        return view('profile.profile', $data);
    }

    // Update user profile picture
    public function updateProfilePicture(Request $request)
    {
        // Get user
        $user = User::find(Auth::user()->id);
        $oldProfilePicture = $user->profile_picture;
        $oldProfilePicturePath = public_path('images/profile/' . $oldProfilePicture);

        // Create new image manager
        $manager = new ImageManager(new Driver());

        // Validate user input
        $request->validate([
            'profile_picture' => ['image', 'mimes:jpeg,png', 'max:1024']
        ]);

        // Process/save image
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $file_name = $user->username . '-' . time() . '.' . $image->getClientOriginalExtension();
            $path = public_path('images/profile/' . $file_name); 

            // Delete old profile picture if exist
            // dd($oldProfilePicturePath);
            if($oldProfilePicture && Storage::exists($oldProfilePicturePath)){
                Storage::delete($oldProfilePicturePath);
            }

            // Save new profile picture
            $manager->read($image->getPathname())->resize(300, 300)->save($path);
    
            // Auth::user()->profile_picture = $file_name;
            // Update profile picture
            $user->update(['profile_picture' => $file_name]);
        }

        return redirect()->route('view-profile')->with('success', 'Profile picture updated');

    }
}
