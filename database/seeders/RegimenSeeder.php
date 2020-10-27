<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegimenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('regimenes')->insert([
            'id' => 1,
            'descripcion' => 'Empleados Agrarios'
        ]);

        DB::table('regimenes')->insert([
            'id' => 2,
            'descripcion' => 'Empleados Regulares'
        ]);

        DB::table('regimenes')->insert([
            'id' => 3,
            'descripcion' => 'Obreros'
        ]);
    }
}
