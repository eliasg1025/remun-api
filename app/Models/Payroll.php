<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "planillas";

    public function empresa()
    {
        return $this->belongsTo(Company::class, 'empresa_id', 'id');
    }

    public function tipoPago()
    {
        return $this->belongsTo(PaymentType::class, 'tipo_pago_id', 'id');
    }
}
