<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        $guichets = \App\Models\Guichet::where('statut', 'Actif')->get();
        return view('auth.login', compact('guichets'));
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
            'guichet_id' => ['required', 'exists:guichet,id'],
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password], $request->boolean('remember'))) {
            $user = Auth::user();
            
            // Check if user is mapped to this guichet
            if (!$user->guichets->contains($request->guichet_id)) {
                Auth::logout();
                return back()->withErrors([
                    'guichet_id' => "Vous n'êtes pas autorisé à vous connecter sur ce guichet.",
                ])->onlyInput('email');
            }

            $request->session()->regenerate();
            session(['guichet_id' => $request->guichet_id]);

            return redirect()->intended('/admin');
        }

        return back()->withErrors([
            'email' => "Les identifiants fournis ne correspondent pas à nos enregistrements.",
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
