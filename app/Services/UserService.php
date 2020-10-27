<?php

namespace App\Services;

use App\Models\Employee;
use App\Models\User;
use App\Repositories\EmployeeRepository;
use App\Repositories\UserRepository;
use App\Repositories\UserRepositoryInterface;
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
}
