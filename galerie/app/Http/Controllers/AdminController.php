<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Zobrazení administrační stránky
    public function index()
    {
        // Zkontrolujeme, zda je nastavena hodnota pro expiration
        if (!session()->has('authenticated') || !session()->has('authenticated_expiration') || now()->greaterThan(session('authenticated_expiration'))) {
            session()->forget(['authenticated', 'authenticated_expiration']);
        }

        return view('admin.index');
    }


    // Ověření hesla
    public function authenticate(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        // Nastavení správného hesla
        $correctPassword = 'heslo';

        if ($request->password === $correctPassword) {
            // Uložení autentizace s časovým omezením (např. 5 minut)
            session(['authenticated' => true]);
            session(['authenticated_expiration' => now()->addMinutes(5)]);
            return redirect()->route('admin.index');
        }

        return redirect()->route('admin.index')->withErrors(['password' => 'Špatné heslo!']);
    }
    
}
