<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "trabajadores";
    protected $primaryKey = 'id';
    protected $fillable = ['id', 'nombre', 'apellido_paterno', 'apellido_materno', 'numero_cuenta', 'banco'];

    public function users()
    {
        return $this->hasMany(User::class, 'trabajador_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'trabajador_id', 'id');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'trabajador_id', 'id');
    }
}
