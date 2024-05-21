<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        // questo cancella TUTTI i token
//        $user->tokens()->delete();

        // questo cancella solo il token usato per accedere alla risorsa
        $user->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout eseguito']);
    }
}
