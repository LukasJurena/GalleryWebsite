<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!session()->has('authenticated')) {
            return redirect()->route('admin.index')->withErrors(['password' => 'Musíte být přihlášeni.']);
        }

        return $next($request);
    }
}
