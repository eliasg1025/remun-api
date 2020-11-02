<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
use App\Utils\UserInfo;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $repository;
    private $service;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
        $this->service = new UserService($repository);
    }

    public function sync()
    {
        return $this->service->sync();
    }

    public function createOtherUser(Request $request)
    {
        $parentUser    = $request->get('user');
        $username      = $request->get('username');
        $password      = $request->get('password');
        $trabajador_id = $request->get('trabajador_id');
        $rol_id        = $request->get('rol_id');

        if (($parentUser->rol->id <= $rol_id) && $parentUser->rol->id !== 4) {
            return response()->json(['message' => 'No puede crear este tipo de usuario'], 401);
        }
        $userInfo = new UserInfo($username, $password, $trabajador_id, $rol_id);

        $user = $this->service->createOtherUser($userInfo);

        if (!$user) {
            return response()->json([
                'message' => 'Hubo algún problema'
            ], 400);
        }

        return response()->json([
            'message' => 'Usuario creado existosamente',
            'data'    => $user
        ], 201);
    }

    public function get(Request $request) {
        $user = $request->get('user');

        return response()->json([
            'users' => $this->service->listUsersByRole($user->rol->id)
        ]);
    }
}
