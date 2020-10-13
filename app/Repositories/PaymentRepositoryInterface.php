<?php


namespace App\Repositories;


interface PaymentRepositoryInterface extends ImportableRepository
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(array $data, $id);
}
