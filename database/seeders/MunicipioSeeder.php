<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Municipio;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class MunicipioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Primero obtenemos los departamentos
        $bogotaDC = Departamento::where('depar_nombre', 'Bogotá D.C.')->first();
        $cundinamarca = Departamento::where('depar_nombre', 'Cundinamarca')->first();

        if ($bogotaDC && $cundinamarca) {
            // Creamos municipios asociados a Bogotá D.C.
            Municipio::firstOrCreate(
                ['muni_nombre' => 'Bogotá D.C.'],
                [
                    'depar_iddepar' => $bogotaDC->iddepar,
                    'estado' => 'Activo',
                    'fecha_registro' => now()
                ]
            );

            // Creamos municipios asociados a Cundinamarca
            Municipio::firstOrCreate(
                ['muni_nombre' => 'Chía'],
                [
                    'depar_iddepar' => $cundinamarca->iddepar,
                    'estado' => 'Activo',
                    'fecha_registro' => now()
                ]
            );

            Municipio::firstOrCreate(
                ['muni_nombre' => 'Zipaquirá'],
                [
                    'depar_iddepar' => $cundinamarca->iddepar,
                    'estado' => 'Activo',
                    'fecha_registro' => now()
                ]
            );
        }
    }
}
