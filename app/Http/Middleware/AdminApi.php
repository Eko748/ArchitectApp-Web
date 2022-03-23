<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->level != 'admin') {
            return response()->json('Role Permission Error', 401);
        }
        return $next($request);
    }
}
