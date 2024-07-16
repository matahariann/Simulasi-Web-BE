<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (!$request->user()) {
            Log::info('No authenticated user');
            abort(403, 'Unauthorized');
        }
    
        if (!$request->user()->role) {
            Log::info('User has no role');
            abort(403, 'Unauthorized');
        }
    
        // Memeriksa apakah role user ada dalam array $roles yang diberikan
        if (!in_array($request->user()->role, $roles)) {
            Log::info('User role is not in the allowed roles', ['userRole' => $request->user()->role, 'allowedRoles' => $roles]);
            abort(403, 'Unauthorized');
        }
    
        return $next($request);
    }
}