<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);
        $user = auth()->user();
        $flag = $user->is_super_admin;

        if ($flag == 1) {
            return $next($request);
        } else {
            return redirect('error');
            // abort(403, 'Unauthorized action.');
        }
    }
}
