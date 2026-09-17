<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ForceAuthorizationFromQuery
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->header('Authorization') && $request->has('token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->query('token'));
        }

        return $next($request);
    }
}