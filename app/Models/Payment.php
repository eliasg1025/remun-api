<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "payments";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'mes', 'anio', 'empresa_id', 'zona_id', 'monto', 'trabajador_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PaymentDetail::class, 'liquidacion_id', 'id');
    }
}
