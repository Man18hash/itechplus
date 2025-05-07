<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use App\Models\ChatMessage;

class ChatController extends Controller
{
    public function index(CartItem $cartItem)
    {
        abort_unless(
            Auth::id() === $cartItem->user_id
            || Auth::guard('admin')->check(),
            403
        );

        return view('chat.index', compact('cartItem'));
    }

    public function fetch(CartItem $cartItem)
    {
        abort_unless(
            Auth::id() === $cartItem->user_id
            || Auth::guard('admin')->check(),
            403
        );

        $messages = ChatMessage::with('user')
            ->where('cart_item_id', $cartItem->id)
            ->orderBy('created_at')
            ->get();

        return response()->json($messages);
    }

    public function store(Request $request, CartItem $cartItem)
    {
        abort_unless(
            Auth::id() === $cartItem->user_id
            || Auth::guard('admin')->check(),
            403
        );

        $data = $request->validate([
            'message'    => 'nullable|string',
            'attachment' => 'nullable|file|max:10240',
        ]);

        // **New**: flag admin by guard, not by route name
        $fromAdmin = Auth::guard('admin')->check();

        $msg = new ChatMessage([
            'cart_item_id' => $cartItem->id,
            'user_id'      => Auth::id(),
            'from_admin'   => $fromAdmin,
            'message'      => $data['message'] ?? null,
        ]);

        if ($file = $request->file('attachment')) {
            $msg->attachment_path = $file->store('chat_attachments','public');
        }

        $msg->save();

        return response()->json($msg->load('user'));
    }
}
