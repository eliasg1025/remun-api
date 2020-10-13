<?php


namespace App\Repositories;


interface ImportableRepository
{
    public function create(array $data);
    public function update(array $data, $id);
}
