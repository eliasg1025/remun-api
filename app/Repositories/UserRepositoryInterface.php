<?php


namespace App\Repositories;


interface UserRepositoryInterface
{
    public function find($id);
    public function create(array $data);
    //public function update(array $data, $id);
}
