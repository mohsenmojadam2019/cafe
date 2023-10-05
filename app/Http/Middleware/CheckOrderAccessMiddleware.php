<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOrderAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $orderId = $request->route('id');

        if ($user && $user->orders->where('id', $orderId)->count() > 0) {
            return $next($request);
        }

        return response()->json(['message' => 'Access denied'], 403);
    }

}
