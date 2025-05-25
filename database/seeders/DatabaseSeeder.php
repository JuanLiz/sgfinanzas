<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            RoleSeeder::class,
            DepartamentoSeeder::class,
            MunicipioSeeder::class,
            UserSeeder::class,

            // Seeders del Plan Único de Cuentas (PUC) - CLASES PRINCIPALES
            PUCActivoSeeder::class,
            PUCPasivoSeeder::class,
            PUCPatrimonioSeeder::class,
            PUCIngresosSeeder::class,
            PUCGastosSeeder::class,
            PUCCostosDeVentaSeeder::class,
            PUCCuentasDeOrdenDeudorasSeeder::class,
            PUCCuentasDeOrdenAcreedorasSeeder::class,

            // Seeders de Contrapartidas del PUC - SUBCUENTAS
            ContrapartidaPUCActivoSeeder::class,
            ContrapartidaPUCPasivoSeeder::class,
            ContrapartidaPUCPatrimonioSeeder::class,
            ContrapartidaPUCIngresosSeeder::class,
            ContrapartidaPUCGastosSeeder::class,
            ContrapartidaPUCCostosDeVentaSeeder::class,
            ContrapartidaPUCCuentasDeOrdenDeudorasSeeder::class,
            ContrapartidaPUCCuentasDeOrdenAcreedorasSeeder::class,

            // Add other seeders here as they are created
        ]);
    }
}
