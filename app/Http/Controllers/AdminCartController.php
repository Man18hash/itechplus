<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminCartController extends Controller
{
    /** View cart/quotations */
    public function index()
    {
        // resources/views/admin/admin-cart.blade.php
        return view('admin.admin-cart');
    }
}
