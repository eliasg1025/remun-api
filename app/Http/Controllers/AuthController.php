<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function me(Request $request)
    {
        $usuario = $request->get('user');

        return response()->json($usuario);
    }

    public function roles(Request $request)
    {
        $usuario = $request->get('user');

        $admUsuarioRoles = DB::table('adm_usuario_roles')
            ->where('usuario_id', $usuario->sub)
            ->get();

        $admUsuarioRoles->transform(function ($item) {
            $item->modulo = DB::table('adm_modulos')->where('id', $item->modulo_id)->first();

            $item->rol = DB::table('adm_roles')->where([
                'id' => $item->rol_id,
                'modulo_id' => $item->modulo_id
            ])->first();

            return $item;
        });

        return response()->json([
            'data' => $admUsuarioRoles
        ]);
    }
}
