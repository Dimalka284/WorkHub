<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckClientLogin
{
    public function handle(Request $request, Closure $next)
    {
        // Check if client is logged in
        if (!session()->has('clientID')) {
            return redirect('login');
        }

        return $next($request);
    }
}
