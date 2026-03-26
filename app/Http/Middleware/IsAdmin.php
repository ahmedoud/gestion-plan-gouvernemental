<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsAdmin
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
        // Vérifier si l'utilisateur est admin (vous pouvez adapter cette condition selon votre modèle de rôle)
        if (!auth()->user() || !auth()->user()->hasRole('admin')) {
            // Si ce n'est pas un admin, rediriger vers une page d'erreur ou une autre page
            return redirect()->route('home')->with('error', 'Accès interdit.');
        }

        return $next($request);
    }
}
