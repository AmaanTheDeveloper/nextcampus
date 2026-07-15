<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        if (!$user) {
            return redirect()->route('login');
        }

        // If status is pending or rejected, block access to all routes except the message pages themselves and logout.
        if ($user->status === 'pending') {
            if (!$request->routeIs('pending.approval') && !$request->routeIs('logout')) {
                return redirect()->route('pending.approval');
            }
            return $next($request);
        }

        if ($user->status === 'rejected') {
            if (!$request->routeIs('rejected') && !$request->routeIs('logout')) {
                return redirect()->route('rejected');
            }
            return $next($request);
        }

        // Check if user is blocked
        if (!empty($user->is_blocked) && $user->is_blocked) {
            // Redirect to blocked page which shows the block_message
            return redirect()->route('blocked');
        }

        // Check role permission
        if (empty($roles)) {
            return $next($request);
        }

        foreach ($roles as $role) {
            if ($user->role === $role) {
                return $next($request);
            }
        }

        abort(403, 'Unauthorized access.');
    }
}
