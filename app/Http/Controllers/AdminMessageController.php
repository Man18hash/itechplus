<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminMessageController extends Controller
{
    /** List all messages */
    public function index()
    {
        // resources/views/admin/admin-message.blade.php
        return view('admin.admin-message');
    }
}
