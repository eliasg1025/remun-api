<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentDetail extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "detalles_pagos";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'liquidacion_id', 'concepto', 'monto_haber_descuento', 'tipo_haber_descuento'];
}
