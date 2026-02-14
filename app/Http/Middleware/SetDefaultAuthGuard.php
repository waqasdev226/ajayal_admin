<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SetDefaultAuthGuard
{
    /**
     * Set the default auth guard for this request based on who is logged in.
     * Admin panel can log in as Agent (agents table) or User (users table).
     * This ensures Auth::user() / Auth::id() resolve correctly after login.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Admin panel: allow both agents and users (admin investors). Set default guard so Auth::user() works.
        if (Auth::guard('agent')->check()) {
            config(['auth.defaults.guard' => 'agent']);
        } elseif (Auth::guard('web')->check()) {
            config(['auth.defaults.guard' => 'web']);
        }

        return $next($request);
    }
}
