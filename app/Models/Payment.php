<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "pagos";
    protected $fillable = ['planilla_id', 'trabajador_id', 'zona_id', 'monto', 'banco', 'numero_cuenta'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PaymentDetail::class, 'planilla_id, trabajador_id');
    }
}
