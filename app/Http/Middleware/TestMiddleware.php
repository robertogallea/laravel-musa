<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $number): Response
    {
        // Operazioni before, agiscono sulla request

        if ($request->magic != $number) {
            abort(401);
        }

        $response = $next($request);

        // Operazioni after, agiscono sulla response

        return $response;
    }
}
