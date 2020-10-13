<?php


namespace App\Repositories;


interface PaymentRepositoryInterface extends ImportableRepositoryInterface
{
    public function all();
    public function find($id);
    public function create(array $data);
    public function update(array $data, $id);
}
