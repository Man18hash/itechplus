<?php

// app/Http/Controllers/CartController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\Project;

class CartController extends Controller
{
    /**
     * Display the current user's cart.
     */
    public function index()
    {
        $items = CartItem::with('project')
                         ->where('user_id', Auth::id())
                         ->where('status', 'pending')
                         ->get();

        return view('business.cart', compact('items'));
    }

    /**
     * Add a project to the authenticated user's cart (quotation list).
     */
    public function add(Project $project)
    {
        CartItem::create([
            'user_id'    => Auth::id(),
            'project_id' => $project->id,
            // status defaults to 'pending'
        ]);

        return back()->with('success', 'Project added to your quotation list.');
    }

    /**
     * Remove a pending cart item.
     */
    public function remove(CartItem $item)
    {
        abort_unless($item->user_id === Auth::id(), 403);

        $item->delete();

        return back()->with('success', 'Quotation removed.');
    }

    /**
     * Update a cart item's status.
     */
    public function updateStatus(Request $request, CartItem $cartItem)
    {
        abort_unless($cartItem->user_id === Auth::id(), 403);

        $request->validate([
            'status' => 'required|in:pending,ordered,cancelled',
        ]);

        $cartItem->update([ 'status' => $request->input('status') ]);

        return back()->with('success', 'Cart item status updated.');
    }

    /**
     * Checkout: convert all pending items into ordered status.
     */
    public function checkout()
    {
        $updated = CartItem::where('user_id', Auth::id())
                           ->where('status', 'pending')
                           ->update(['status' => 'ordered']);

        if ($updated) {
            return redirect()->route('cart.index')
                             ->with('success', 'Checkout successful! '.$updated.' item(s) ordered.');
        }

        return redirect()->route('cart.index')
                         ->with('warning', 'You have no pending items to checkout.');
    }
}
