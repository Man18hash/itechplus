<?php
// app/Http/Controllers/Admin/HomeController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class HomeController extends Controller
{
    /**
     * Show the admin home with all projects.
     */
    public function index(Request $request)
    {
        // Eager-load category, order newest first, and pull _all_ records
        $projects = Project::with('category')
                           ->orderBy('created_at', 'desc')
                           ->get();

        return view('admin.home', compact('projects'));
    }
}
