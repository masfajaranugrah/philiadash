<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class UserController extends Controller
{
    //index
    public function index()
    {
        $user = Auth::user();
         // Ambil data user yang sedang login
        return view('pages-profile', compact('user'));
    }

    public function view()
    {
        $user = Auth::user();
         // Ambil data user yang sedang login
        return view('profile', compact('user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'email',
            'description' => 'nullable|string|max:500',           
            'firstname' => 'string|max:255',
            'lastname' => 'string|max:255',
            'phone_number' => 'string|max:15',
         
         ]);
    
        UserProfile::create([
            'email' => $request->email,
            'description' => $request->description,       
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
         
            // 'profile_image' => $file_name,
        ]);
    
        return redirect()->route('user')->with('success', 'Profile updated successfully.');
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email',
            'description' => 'nullable|string|max:500',           
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'phone_number' => 'required|string|max:15',
        ]);
    
        // Ambil data user berdasarkan ID
        $userProfile = UserProfile::findOrFail($id);
    
        // Update data
        $userProfile->update([
            'email' => $request->email,
            'description' => $request->description,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone_number' => $request->phone_number,
        ]);
    
        return redirect()->route('user')->with('success', 'Profile updated successfully.');
    }
    
 
 
 

    public function updatePassword(Request $request, $id)
    {
    
        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            
            return redirect()->route('user')->with('error', 'Password tidak sama.');

        } else {
            $user = UserProfile::find($id);
            $user->password = Hash::make($request->get('new-password'));
            $user->update();
            
        }


        return redirect()->route('user')->with('success', 'Password updated successfully.');

    }
   
   
 
}

