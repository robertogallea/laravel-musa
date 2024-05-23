<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // leggiamo il valore del parametro lang nella query string
        $locale = $request->query('lang');

        // se il valore esiste impostiamo la lingua e scriviamo il valore in sessione
        if ($locale) {
            \Illuminate\Support\Facades\App::setLocale($locale);
            session()->put('locale', $locale);
        } elseif (session()->has('locale')) { // altrimenti vedo se è presente un valore in sessione impostato precedentemente e in caso affermativo lo uso per impostare la lingua
            \Illuminate\Support\Facades\App::setLocale(session()->get('locale'));
        }

        // in tutti gli altri casi uso la lingua predefinita


        return $next($request);
    }
}
