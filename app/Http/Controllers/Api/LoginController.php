<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        // Verificare le credenziali email e password
        $validCredentials = Auth::attempt($credentials);

        // Se le credenziali non sono valide restituisco un errore
        if (!$validCredentials) {
            return response()->json(['message' => 'Credenziali non valide']);
        }

        // se sono valide, recupero l'utente e creo un token
        $user = User::where('email', $request->email)->first();

        if ($user->isAdmin()) {
            $abilities = ['*'];
            $expirationDate = null;
        } else {
            $abilities = ['read'];
            $expirationDate = now()->addHour();
        }

        $token = $user->createToken('default_token', $abilities, $expirationDate)->plainTextToken;

        // restituisco il token
        return response()->json(['token' => $token]);
    }
}
