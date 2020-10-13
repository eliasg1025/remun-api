<?php


namespace App\Repositories;


interface ImportableRepositoryInterface
{
    public function create(array $data);
    public function update(array $data, $id);
}
