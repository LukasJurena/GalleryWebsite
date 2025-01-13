<?php

// app/Http/Middleware/AdminMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Zkontroluj, zda je uživatel přihlášen a zda je administrátor
        if (!auth()->check() || !auth()->user()->is_admin) {
            // Přesměrování na domovskou stránku nebo jinou stránku
            return redirect('/');
        }

        return $next($request);
    }
}
