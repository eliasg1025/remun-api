<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use Illuminate\Http\Request;

class RolController extends Controller
{
    public function get(Request $request)
    {
        $usuario = $request->get('user');
        $roles = Rol::where('id', '<', $usuario->rol->id)->get();
        return response()->json($roles);
    }
}
