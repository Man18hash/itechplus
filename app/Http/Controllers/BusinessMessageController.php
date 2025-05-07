<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;

class BusinessMessageController extends Controller
{
    public function index()
    {
        $threads = CartItem::with('project')
            ->where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('business.messages', compact('threads'));
    }
}
