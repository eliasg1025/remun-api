<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\Rol;
use App\Models\Trabajador;
use Firebase\JWT\JWT;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class JwtAuthService
{
    public static function signin(string $username, string $password)
    {
        $usuario = User::where([
            'username' => $username,
            'password' => $password
        ])->first();

        if (!$usuario) {
            return [
                'error'   => true,
                'message' => 'El usuario no existe',
                'token' => false
            ];
        }

        $trabajador = Employee::where('id', $usuario->trabajador_id)
                ->select('id', 'apellido_paterno', 'apellido_materno', 'nombre')
                ->first();

        $rol = Rol::where('id', $usuario->rol_id)->first();

        /* $admUsuarioRoles = DB::table('adm_usuario_roles')
            ->where('usuario_id', 6)
            ->get();

        $admUsuarioRoles->transform(function ($item) {
            $item->modulo = DB::table('adm_modulos')->where('id', $item->modulo_id)->first();

            $item->rol = DB::table('adm_roles')->where([
                'id' => $item->rol_id,
                'modulo_id' => $item->modulo_id
            ])->first();

            return $item;
        }); */

        $token = [
            'sub'        => $usuario->id,
            'username'   => $usuario->username,
            'trabajador' => $trabajador,
            'rol'        => $rol,
            'iat'        => time(),
            'exp'        => time() + (7 * 24 * 60 * 60)
        ];

        $jwt = JWT::encode($token, env('JWT_KEY'), 'HS256');

        return [
            'error'   => false,
            'message' => 'Usuario logeado correctamente',
            'token'   => $jwt
        ];
    }

    public static function checkToken($jwt, $get_identity=false)
    {
        $auth = false;
        try {
            $decoded = JWT::decode($jwt, env('JWT_KEY'), ['HS256']);
        } catch (\Exception $e) {
            $auth = false;
        }

        if (!empty($decoded) && is_object($decoded) && isset($decoded->sub)) {
            $auth = true;
        }

        if ($get_identity) {
            return $decoded;
        }

        return $auth;
    }
}
