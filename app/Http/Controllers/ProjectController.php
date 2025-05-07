<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;

class ProjectController extends Controller
{
    /**
     * Landing page handler for guests, business users, and admins.
     */
    public function landingRedirect(Request $request)
    {
        // 1) If logged in as admin, go to admin home
        if (auth('admin')->check()) {
            return redirect()->route('admin.home');
        }

        // 2) If logged in as business user, go to business home
        if (auth()->check()) {
            return redirect()->route('home');
        }

        // 3) Otherwise, show the public dashboard
        return $this->dashboard($request);
    }

    /**
     * Guest landing page (dashboard) — now shows ALL projects on one page.
     */
    public function dashboard(Request $request)
    {
        $search   = $request->query('search');
        $category = $request->query('category');

        $query = Project::with('category')
            ->when($search, function($q) use ($search) {
                $q->where(function($q2) use ($search) {
                    $q2->where('project_name', 'like', "%{$search}%")
                       ->orWhere('description',    'like', "%{$search}%");
                })
                ->orWhereHas('category', function($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });
            })
            ->when($category, function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->latest();

        // fetch ALL matching projects
        $projects   = $query->get();
        $categories = Category::orderBy('name')->pluck('name', 'id');

        return view('dashboard', compact(
            'projects',
            'search',
            'category',
            'categories'
        ));
    }

    /**
     * Authenticated home view (business dashboard) — now shows ALL projects on one page.
     */
    public function homeView(Request $request)
    {
        $search   = $request->query('search');
        $type     = $request->query('type');
        $category = $request->query('category');

        $types = Project::select('project_type')
                        ->distinct()
                        ->orderBy('project_type')
                        ->pluck('project_type');

        $categories = Category::orderBy('name')->pluck('name', 'id');

        $query = Project::with('category')
            ->when($search, function($q) use ($search) {
                $q->where(function($q2) use ($search) {
                    $q2->where('project_name', 'like', "%{$search}%")
                       ->orWhere('description',    'like', "%{$search}%");
                })
                ->orWhereHas('category', function($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });
            })
            ->when($type, function($q) use ($type) {
                $q->where('project_type', $type);
            })
            ->when($category, function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->latest();

        // fetch ALL matching projects
        $projects = $query->get();

        return view('business.projects', compact(
            'projects',
            'types',
            'categories',
            'search',
            'type',
            'category'
        ));
    }

    /**
     * Projects listing page (for guests) — unchanged, still paginated.
     */
    public function projects(Request $request)
    {
        $search   = $request->query('search');
        $type     = $request->query('type');
        $category = $request->query('category');

        $types = Project::select('project_type')
                        ->distinct()
                        ->orderBy('project_type')
                        ->pluck('project_type');

        $categories = Category::orderBy('name')->pluck('name', 'id');

        $query = Project::with('category')
            ->when($search, function($q) use ($search) {
                $q->where(function($q2) use ($search) {
                    $q2->where('project_name', 'like', "%{$search}%")
                       ->orWhere('description',    'like', "%{$search}%");
                })
                ->orWhereHas('category', function($q3) use ($search) {
                    $q3->where('name', 'like', "%{$search}%");
                });
            })
            ->when($type, function($q) use ($type) {
                $q->where('project_type', $type);
            })
            ->when($category, function($q) use ($category) {
                $q->where('category_id', $category);
            })
            ->latest();

        $projects = $query->paginate(9)->withQueryString();

        return view('projects', compact(
            'projects',
            'types',
            'categories',
            'search',
            'type',
            'category'
        ));
    }

    /**
     * Handle a "Get Quotation" request.
     */
    public function requestQuote(Project $project)
    {
        return view('quote-request', compact('project'));
    }
}
