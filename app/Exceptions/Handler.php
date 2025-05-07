<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    // …

    /**
     * Convert an authentication exception into a redirect.
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // JSON clients get a JSON error
        if ($request->expectsJson()) {
            return response()->json(['message' => $exception->getMessage()], 401);
        }

        // Web clients get sent to `route('login')` with a flash
        return redirect()->guest(route('login'))
                         ->with('error', 'Please log in to continue.');
    }
}
