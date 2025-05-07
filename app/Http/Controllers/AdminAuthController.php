<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;           // ← import the Project model

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.admin.login');
    }

    public function login(Request $req)
    {
        $credentials = $req->validate([
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::guard('admin')->attempt($credentials, $req->filled('remember'))) {
            return redirect()->route('admin.home');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials or not an admin.'
        ]);
    }

    /**
     * Admin landing page — now loads recent projects!
     */
    public function home(Request $request)
    {
        // load latest 9 projects with their category
        $projects = Project::with('category')
                           ->latest()
                           ->paginate(9);

        // render resources/views/admin/home.blade.php
        return view('admin.home', compact('projects'));
    }

    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('admin.login');
    }
}
