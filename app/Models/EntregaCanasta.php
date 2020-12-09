<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntregaCanasta extends Model
{
    use HasFactory;

    protected $table = 'entregas_canastas';

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id', 'id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Employee::class, 'trabajador_id', 'id');
    }

    public function empresa()
    {
        return $this->belongsTo(Company::class, 'empresa_id', 'id');
    }
}
