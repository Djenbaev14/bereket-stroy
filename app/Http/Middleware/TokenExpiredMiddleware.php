<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class TokenExpiredMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && $request->user()->tokens()->where('created_at', '<', now()->subMinutes(30))->exists()) {
            $request->user()->tokens()->delete();
            return response()->json(['message' => 'Token muddati tugagan!'], 401);
        }
        return $next($request);
    }
}
