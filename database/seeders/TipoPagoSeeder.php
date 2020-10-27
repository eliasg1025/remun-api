<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TipoPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tipos_pagos')->insert([
            'id' => 1,
            'descripcion' => 'SUELDO'
        ]);

        DB::table('tipos_pagos')->insert([
            'id' => 2,
            'descripcion' => 'ANTICIPO'
        ]);
    }
}
