<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Employee extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $collection = "employees";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'apellido_paterno', 'apellido_materno', 'numero_cuenta', 'banco'];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'trabajador_id', 'id');
    }
}
