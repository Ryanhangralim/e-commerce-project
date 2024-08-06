<?php

namespace App\Http\Controllers;

use App\Models\User;
use Svg\Gradient\Stop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProfileController extends Controller
{
    protected $profile_picture_path;
    
    // constructor
    public function __construct()
    {
        $this->profile_picture_path = env('PROFILE_PICTURE_PATH');
    }

    // Return profile page 
    public function viewProfile()
    {
        $user = Auth::user();

        $data = [
            'user' => $user,
            'profile_picture_path' => $this->profile_picture_path,
        ];

        return view('profile.profile', $data);
    }

    // Update user profile picture
    public function updateProfilePicture(Request $request)
    {
        // Get user
        $user = User::find(Auth::user()->id);
        $oldProfilePicture = $user->profile_picture;
        $oldProfilePicturePath = public_path($this->profile_picture_path . $oldProfilePicture);

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
            $path = public_path($this->profile_picture_path . $file_name); 

            // Delete old profile picture if exist
            if($oldProfilePicture && File::exists($oldProfilePicturePath)){
                File::delete($oldProfilePicturePath);
            }

            // Save new profile picture
            $manager->read($image->getPathname())->resize(300, 300)->save($path);
    
            // Update profile picture
            $user->update(['profile_picture' => $file_name]);

            return redirect()->route('view-profile')->with('success', 'Profile picture updated');
        }

        return redirect()->back();
    }
}
