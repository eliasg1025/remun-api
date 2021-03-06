<?php

namespace App\Models;

use App\Services\JwtAuthService;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $timestamps = false;
    protected $table = "usuarios";
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * @var array
     */
    protected $fillable = [
        'username',
        'password',
        'trabajador_id',
        'rol_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    public function rol()
    {
        return $this->belongsTo(Rol::class, 'rol_id', 'id');
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'trabajador_id', 'id');
    }

    public function trabajador()
    {
        return $this->belongsTo(Employee::class, 'trabajador_id', 'id');
    }

    public static function login($data)
    {
        $username = $data['username'];
        $password = md5(sha1($data['password']));

        $token = JwtAuthService::signin($username, $password);

        return $token;
    }

    public static function verify($token)
    {
        $verification = JwtAuthService::checkToken($token, true);

        if (!$verification) {
            return [
                'error' => true,
                'message' => 'Error al autenticar el usuario'
            ];
        }

        return [
            'error' => false,
            'message'  => 'Datos obtenidos correctamente',
            'data' => $verification
        ];
    }
}
