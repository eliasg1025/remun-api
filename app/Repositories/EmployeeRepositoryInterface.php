<?php


namespace App\Repositories;


interface EmployeeRepositoryInterface extends ImportableRepositoryInterface
{
    public function find($id);
    public function create(array $data);
    public function update(array $data, $id);
}
