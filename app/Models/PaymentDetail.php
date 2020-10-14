<?php

namespace App\Models;

use \Jenssegers\Mongodb\Eloquent\Model;

class PaymentDetail extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $collection = "payments_detail";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'liquidacion_id', 'concepto', 'monto_haber_descuento', 'tipo_haber_descuento'];
}
