<?php

// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard with all projects.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Project::with('category');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('project_name', 'like', "%{$search}%")
                  ->orWhere('description',   'like', "%{$search}%")
                  ->orWhereHas('category', function($q2) use ($search) {
                      $q2->where('name', 'like', "%{$search}%");
                  });
            });
        }

        // **Fetch all** matching records (no pagination)
        $projects = $query->latest()->get();

        return view('admin.dashboard', compact('projects', 'search'));
    }
}

