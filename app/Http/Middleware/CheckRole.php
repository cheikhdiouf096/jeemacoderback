<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  int  $roleId
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Vérifiez si l'utilisateur est authentifié et a le rôle spécifié
        if (Auth::check() && Auth::user()->role == "organisateur") {
            return $next($request);
        }

        // Si l'utilisateur n'a pas le rôle requis, renvoyer une réponse d'erreur
        return response()->json(['error' => 'cet utilisateur n\'a pas l\'autorisation de créer un hackathon'], 403);
    }
}
