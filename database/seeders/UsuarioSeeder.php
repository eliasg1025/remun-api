<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usuarios')->insert([
            'username'      => 'root',
            'password'      => md5(sha1(env('MASTER_KEY'))),
            'rol_id'        => 4,
            'trabajador_id' => '72437334'
        ]);
    }
}
