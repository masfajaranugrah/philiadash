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
        'email' => 'required|email',
        'description' => 'nullable|string|max:500',           
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'phone_number' => 'required|string|max:15',
        'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    ]);

  
    $gambar = $request->file('profile');
      dd( $gambar);
    if ($gambar) {
        $file_name = time() . '_' . $gambar->getClientOriginalName();
        $gambar->storeAs('public/profile/', $file_name);

      
    UserProfile::create([
        'email' => $request->email,
        'description' => $request->description,       
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'phone_number' => $request->phone_number,
        'profile' => $file_name
    ]);

    return redirect()->route('user')->with('success', 'Profile updated successfully.');
 
    }



}

    
 
public function update(Request $request, $id)
{
    $request->validate([
        'email' => 'required|email',
        'description' => 'nullable|string|max:500',           
        'firstname' => 'required|string|max:255',
        'lastname' => 'required|string|max:255',
        'phone_number' => 'required|string|max:15',
        'profile' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        'foreground' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
    ]);

    // Ambil data user berdasarkan ID
    $userProfile = UserProfile::findOrFail($id);

    // Array untuk update data
    $updateData = [
        'email' => $request->email,
        'description' => $request->description,
        'firstname' => $request->firstname,
        'lastname' => $request->lastname,
        'phone_number' => $request->phone_number,
    ];

    // Cek jika ada gambar profil yang diunggah
    if ($request->hasFile('profile')) {
        // Hapus file lama jika ada
        if ($userProfile->profile) {
            Storage::delete('public/profile/' . $userProfile->profile);
        }

        $file_name = time() . '_' . $request->file('profile')->getClientOriginalName();
        $request->file('profile')->storeAs('public/profile/', $file_name);
        $updateData['profile'] = $file_name;
    }

    // Cek jika ada foreground yang diunggah
    if ($request->hasFile('foreground')) {
        // Hapus file lama jika ada
        if ($userProfile->foreground) {
            Storage::delete('public/foreground/' . $userProfile->foreground); // Sesuaikan folder penyimpanan
        }

        $file_name1 = time() . '_' . $request->file('foreground')->getClientOriginalName();
        $request->file('foreground')->storeAs('public/foreground/', $file_name1); // Sesuaikan folder penyimpanan
        $updateData['foreground'] = $file_name1;
    }

    // Update data user
    $userProfile->update($updateData);

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

