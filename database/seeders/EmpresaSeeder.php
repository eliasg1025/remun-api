<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmpresaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('empresas')->insert([
            'id' => 9,
            'nombre' => 'SOCIEDAD AGRICOLA RAPEL SAC',
            'nombre_corto' => 'RAPEL'
        ]);

        DB::table('empresas')->insert([
            'id' => 14,
            'nombre' => 'SOCEDAD EXPORTADORA VERFRUT SAC',
            'nombre_corto' => 'VERFRUT'
        ]);
    }
}
