<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class AuthController extends Controller
{
    public function show()
    {
        return view('auth.login');
    }

    public function register(Request $req)
    {
        $data = $req->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'company_size' => 'nullable|string|max:50',
            'position'     => 'nullable|string|max:100',
            'street'       => 'nullable|string|max:100',
            'barangay'     => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'region'       => 'nullable|string|max:100',
            'mobile'       => 'nullable|string|max:20',
            'email'        => 'required|email|unique:users',
            'password'     => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);

        Auth::guard('web')->login($user);
        return redirect()->route('home');
    }

    public function login(Request $req)
    {
        $creds = $req->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('web')->attempt($creds, $req->filled('remember'))) {
            return redirect()->route('home');
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function logout()
    {
        Auth::guard('web')->logout();
        return redirect()->route('login');
    }

    public function updateProfile(Request $req)
    {
        $req->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $user = Auth::guard('web')->user();
        $path = $req->file('profile_image')->store('profile_images', 'public');

        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->profile_image = $path;
        $user->save();

        return back()->with('success', 'Profile image updated.');
    }

    public function updateInfo(Request $req)
    {
        $data = $req->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'company_size' => 'nullable|string|max:50',
            'position'     => 'nullable|string|max:100',
            'street'       => 'nullable|string|max:100',
            'barangay'     => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'region'       => 'nullable|string|max:100',
            'mobile'       => 'nullable|string|max:20',
        ]);

        $user = Auth::guard('web')->user();
        $user->update($data);

        return back()->with('success', 'Profile information updated.');
    }
}
