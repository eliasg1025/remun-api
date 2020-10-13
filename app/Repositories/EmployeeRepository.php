<?php


namespace App\Repositories;


use App\Models\Employee;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeRepository implements EmployeeRepositoryInterface
{
    protected $model;

    public function __construct(Employee $employee)
    {
        $this->model = $employee;
    }

    public function find($id)
    {
        if (null == $payment = $this->model->find($id))
        {
            throw new ModelNotFoundException("Liquidación no encontrada");
        }
        return $payment;
    }

    public function create(array $data)
    {
        return $this->model->create($data);
    }

    public function update(array $data, $id)
    {
        return $this->model->where('id', $id)->update($data);
    }
}
