<?php

namespace App\Http\Controllers;

use App\Models\Category;

class ResearchController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('research.researches', compact('categories'));
    }
}
