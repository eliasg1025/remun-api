<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $result = User::login($request->all());

        if ($result['error']) {
            return response()->json([
                'message' => $result['message'],
            ], 401);
        }

        return response()->json([
            'message' => $result['message'],
            'token'   => $result['token']
        ], 200);
    }

    public function logout(Request $request)
    {
        return response()->json($request);
    }
}
