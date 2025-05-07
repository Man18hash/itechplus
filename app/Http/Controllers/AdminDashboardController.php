<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class AdminDashboardController extends Controller
{
    public function index(Request $request)
    {
        // grab the search term (if any)
        $search = $request->get('search');

        // build the query
        $query = Project::query();

        if ($search) {
            $query->where('project_name', 'like', "%{$search}%");
        }

        // paginate instead of get(); change 12 to however many per page you like
        $projects = $query->paginate(12)
                          ->withQueryString();  // so ?search=foo stays in the URL

        return view('dashboard', compact('projects', 'search'));
    }
}
