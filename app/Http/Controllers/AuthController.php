<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function sendCodeNewPassword(Request $request)
    {
        return response()->json([
            'code' => 1234
        ]);
    }

    public function resetPassword(Request $request)
    {
        return response()->json([
            'message' => 'Senha alterada com sucesso'
        ]);
    }

}