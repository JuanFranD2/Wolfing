<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Http\Request;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $googleUser = Socialite::driver('google')->user();

        // Verificar si el usuario ya existe por correo electrónico
        $user = User::where('email', $googleUser->email)->first();

        if (!$user) {
            // Si no existe, crear uno nuevo
            $user = User::create([
                'google_id' => $googleUser->id,
                'name' => $googleUser->name,
                'email' => $googleUser->email,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        } else {
            // Si ya existe, solo actualizar los tokens de Google
            $user->update([
                'google_id' => $googleUser->id,
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);
        }

        // Iniciar sesión y regenerar sesión
        Auth::login($user);
        $request->session()->regenerate();

        // Redirigir a la ruta del dashboard
        return redirect()->route('dashboard');
    }
}
