<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Payment extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $collection = "payments";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'mes', 'anio', 'empresa_id', 'zona_id', 'monto', 'trabajador_id'];

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
