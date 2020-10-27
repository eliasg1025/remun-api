<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
use App\Utils\UserInfo;
use Illuminate\Support\Facades\DB;

class UserService
{
    private $repository;

    public function __construct (UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }

    public function sync()
    {
        $trabajadores = Employee::all();

        foreach ($trabajadores as $trabajador) {
            $this->repository->create([
                'username' => $trabajador->id,
                'password' => md5(sha1($trabajador->id)),
                'trabajador_id' => $trabajador->id
            ]);
        }

        return ['completado'];
    }

    public function createOtherUser(UserInfo $userInfo)
    {
        return $this->repository->create([
            'username'      => $userInfo->getUsername(),
            'password'      => $userInfo->getPassword(),
            'trabajador_id' => $userInfo->getTrabajadorId(),
            'rol_id'        => $userInfo->getRolId()
        ]);
    }
}
