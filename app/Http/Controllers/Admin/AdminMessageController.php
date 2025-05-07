<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartItem;

class AdminMessageController extends Controller
{
    public function index()
    {
        $threads = CartItem::with('user','project')
            ->latest()
            ->get();

        return view('admin.admin-messages', compact('threads'));
    }
}
