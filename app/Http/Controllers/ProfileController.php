<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Update the authenticated user’s profile image.
     */
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|max:2048',
        ]);

        $user = $request->user();

        // delete old image if exists
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        // store new file under storage/app/public/profiles
        $path = $request->file('profile_image')->store('profiles', 'public');

        // save path on user
        $user->profile_image = $path;
        $user->save();

        return back()->with('success', 'Profile image updated.');
    }

    /**
     * Update the authenticated user’s profile info.
     */
    public function updateInfo(Request $request)
    {
        $data = $request->validate([
            'first_name'   => 'required|string|max:50',
            'last_name'    => 'required|string|max:50',
            'company_name' => 'nullable|string|max:100',
            'company_size' => 'nullable|string|max:50',
            'position'     => 'nullable|string|max:50',
            'mobile'       => 'nullable|string|max:20',
            'street'       => 'nullable|string|max:100',
            'barangay'     => 'nullable|string|max:100',
            'city'         => 'nullable|string|max:100',
            'region'       => 'nullable|string|max:100',
        ]);

        $request->user()->update($data);

        return back()->with('success', 'Profile information updated.');
    }
}
