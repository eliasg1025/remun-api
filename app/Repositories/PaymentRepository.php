<?php


namespace App\Repositories;


use App\Models\Payment;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymentRepository implements PaymentRepositoryInterface
{
    protected $model;

    public function __construct(Payment $payment)
    {
        $this->model = $payment;
    }

    public function all()
    {
        return $this->model->all();
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
        //return $this->model->where('id', $id)->update($data);
        return $this->model->updateOrInsert(['id' => $id], $data);
    }
}
