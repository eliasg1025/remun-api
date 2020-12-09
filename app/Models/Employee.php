<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $table = "trabajadores";
    protected $fillable = ['id', 'nombre', 'apellido_paterno', 'apellido_materno', 'empresa_id',];

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

    public function regimen()
    {
        return $this->belongsTo(Regimen::class, 'regimen_id', 'id');
    }

    public function entregasCanastas()
    {
        return $this->hasMany(EntregaCanasta::class, 'trabajador_id', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Company::class, 'empresa_id', 'id');
    }
}
