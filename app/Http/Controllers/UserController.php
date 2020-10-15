<?php

namespace App\Http\Controllers;

use App\Repositories\UserRepositoryInterface;
use App\Services\UserService;
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
}
