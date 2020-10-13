<?php


namespace App\Repositories;


use App\Models\PaymentDetail;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PaymenDetailRepository implements PaymentDetailRepositoryInterface
{
    protected $model;

    public function __construct(PaymentDetail $paymentDetail)
    {
        $this->model = $paymentDetail;
    }

    public function find($id)
    {
        if (null == $payment = $this->model->find($id))
        {
            throw new ModelNotFoundException("Detalle de liquidacion no encontrado");
        }
        return $payment;
    }

    public function create(array $data)
    {
        // TODO: Implement create() method.
    }

    public function update(array $data, $id)
    {
        // TODO: Implement update() method.
    }
}
