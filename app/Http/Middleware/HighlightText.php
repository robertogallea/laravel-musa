<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HighlightText
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // le operazioni da svolgere vanno inserite qui
        $content = $response->getContent();

        $word = $request->highlight;

        if ($word) {
            $content = str_replace($word, '<span style="background-color: #FFFF00">' . $word . '</span>', $content);

            $response->setContent($content);
        }

        return $response;
    }
}
