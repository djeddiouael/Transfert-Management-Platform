<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AgentMiddleware
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
        if (auth()->check() && auth()->user()->user_type === 'agent') {
            return $next($request);
        }

        return redirect('/')->with('error', 'Accès non autorisé');
    }
} 