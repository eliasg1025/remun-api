<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('roles')->insert([
            'id' => 1,
            'descripcion' => 'TRABAJADOR'
        ]);

        DB::table('roles')->insert([
            'id' => 2,
            'descripcion' => 'SUPERVISOR'
        ]);

        DB::table('roles')->insert([
            'id' => 3,
            'descripcion' => 'COORDINADOR'
        ]);

        DB::table('roles')->insert([
            'id' => 4,
            'descripcion' => 'ADMINISTRADOR'
        ]);
    }
}
