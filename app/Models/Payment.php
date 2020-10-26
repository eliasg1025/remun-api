<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "pagos";
    protected $fillable = ['id', 'tipo_pago_id', 'mes', 'anio', 'empresa_id', 'zona_id', 'monto', 'trabajador_id', 'banco', 'numero_cuenta'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PaymentDetail::class, 'pago_id', 'id');
    }
}
