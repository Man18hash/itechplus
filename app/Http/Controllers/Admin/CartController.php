<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Display a listing of the cart items.
     */
    public function index()
    {
        // eager‐load user and project
        $cartItems = CartItem::with('user', 'project')
                             ->latest()
                             ->get();

        return view('admin.admin-cart', compact('cartItems'));
    }

    /**
     * Update the status of a cart item.
     */
    public function update(Request $request, CartItem $cartItem)
    {
        $validated = $request->validate([
            'status' => 'required|in:quotation,ongoing,delivered',
        ]);

        $cartItem->update(['status' => $validated['status']]);

        return back()->with('success', 'Cart item status updated.');
    }
}
