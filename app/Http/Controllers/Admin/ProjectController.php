<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use Illuminate\Support\Str;

class ProjectController extends Controller
{
    /**
     * Display a listing of all projects.
     */
    public function index()
    {
        // load ALL projects, sorted by most recent
        $projects   = Project::with('category')->latest()->get();
        $categories = Category::all();
        return view('admin.admin-projects', compact('projects','categories'));
    }

    /**
     * Store a newly created project.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'project_type'  => 'required|string|max:255',
            'project_name'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'category_id'   => 'required|exists:categories,id',
            'cover_image'   => 'nullable|image|max:2048',
        ]);

        if ($file = $request->file('cover_image')) {
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                      .'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images/covers'), $filename);
            $data['cover_image'] = $filename;
        }

        Project::create($data);

        return back()->with('success', 'Project created.');
    }

    /**
     * Update the specified project.
     */
    public function update(Request $request, Project $project)
    {
        $data = $request->validate([
            'project_type'  => 'required|string|max:255',
            'project_name'  => 'required|string|max:255',
            'description'   => 'nullable|string',
            'date'          => 'required|date',
            'category_id'   => 'required|exists:categories,id',
            'cover_image'   => 'nullable|image|max:2048',
        ]);

        if ($file = $request->file('cover_image')) {
            if ($project->cover_image && file_exists(public_path('images/covers/'.$project->cover_image))) {
                @unlink(public_path('images/covers/'.$project->cover_image));
            }
            $filename = time().'_'.Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME))
                      .'.'.$file->getClientOriginalExtension();
            $file->move(public_path('images/covers'), $filename);
            $data['cover_image'] = $filename;
        }

        $project->update($data);

        return back()->with('success', 'Project updated.');
    }

    /**
     * Remove the specified project.
     */
    public function destroy(Project $project)
    {
        if ($project->cover_image && file_exists(public_path('images/covers/'.$project->cover_image))) {
            @unlink(public_path('images/covers/'.$project->cover_image));
        }

        $project->delete();
        return back()->with('success', 'Project deleted.');
    }
}
