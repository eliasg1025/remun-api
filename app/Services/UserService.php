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
        $result = Employee::all()->chunk(500, function ($employees) {
            foreach ($employees as $employee) { // TODO
                $this->repository->create([
                    'username' => $employee->id,
                    'password' => md5(sha1($employee->id)),
                    'employee_id' => $employee->id
                ]);
            }
        });

        return $result;
    }
}
