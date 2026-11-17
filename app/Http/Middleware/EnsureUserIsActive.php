<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsActive
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        // pending or suspended users are logged out and sent to the login page
        if ($user && $user->status !== 'active') {
            $message = $user->status === 'pending'
                ? 'Your account is waiting for administrator approval.'
                : 'Your account has been suspended. Please contact the administrator.';

            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => $message]);
        }

        return $next($request);
    }
}