<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Departamento;
use Illuminate\Support\Facades\DB;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Departamento::firstOrCreate(
            ['depar_nombre' => 'Bogotá D.C.'],
            [
                'estado' => 'Activo',
                'fecha_registro' => now()
            ]
        );

        Departamento::firstOrCreate(
            ['depar_nombre' => 'Cundinamarca'],
            [
                'estado' => 'Activo',
                'fecha_registro' => now()
            ]
        );
    }
}
