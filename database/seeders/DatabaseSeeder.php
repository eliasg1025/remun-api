<?php

namespace Database\Seeders;

use App\Models\Regimen;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            EmpresaSeeder::class,
            RolSeeder::class,
            UsuarioSeeder::class,
            RegimenSeeder::class,
            TipoPagoSeeder::class,
        ]);
    }
}
