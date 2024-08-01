<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    // User table page
    public function viewUser()
    {
        $users = User::all();

        $data = [
            'users' => $users
        ];

        return view('dashboard.admin.user', $data);
    }

    // Fetch users data for table
    public function fetchUsers(Request $request)
    {
        $role = $request->get('role');

        if($role === "all"){
            $users = User::with('role')->get();
        } else {
            $users = User::join('roles', 'users.role_id', '=', 'roles.id')
            ->where('roles.title', $role)
            ->select('users.*') // Select only user columns
            ->with('role') // Eager load the role relationship
            ->get();        
        }
        return response()->json(['users' => $users]);
    }

    // Update role method
    public function updateRole(Request $request)
    {
        // Fetch data from request
        $userID = $request['user_id'];
        $roleID = $request['role_id'];

        // Update role
        User::where('id', $userID)->update(['role_id'=> $roleID]);

        // Redirect user back
        return redirect()->back()->with('success', 'User role has been updated!');
    }
}
