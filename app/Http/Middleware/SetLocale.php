<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class SetLocale
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
        // Vérifier si la langue est stockée en session
        if (session()->has('locale')) {
            App::setLocale(session('locale'));
        } else {
            // Sinon, utiliser la langue par défaut
            App::setLocale('en');
        }

        return $next($request);
    }
} 