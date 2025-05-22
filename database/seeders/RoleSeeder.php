<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['rol_descripcion' => 'Administrador'],
            [
                'estado' => 'Activo',
                'fecha_registro' => now()
            ]
        );

        Role::firstOrCreate(
            ['rol_descripcion' => 'Usuario'],
            [
                'estado' => 'Activo',
                'fecha_registro' => now()
            ]
        );
    }
}
