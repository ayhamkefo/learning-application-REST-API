<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return response()->json([
                'status' => 403,
                'message' => 'Not Authenticated',
            ], 403);
        }
        if (Auth::user()->role != 'admin') {
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized action this route for admin only'
            ], 403);
        }
        return $next($request);
    }
}
