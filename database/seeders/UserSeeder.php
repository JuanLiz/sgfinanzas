<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminRole = Role::where('rol_descripcion', 'Administrador')->first();
        $bogotaMun = Municipio::where('muni_nombre', 'Bogotá D.C.')->first();

        if ($adminRole && $bogotaMun) {
            User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'usua_nombre' => 'Admin User',
                    'password' => Hash::make('password'), // Change 'password' to a secure default
                    'rol_idrol' => $adminRole->idrol,
                    'muni_idmuni' => $bogotaMun->idmuni,
                    'estado' => 'Activo',
                    'email_verified_at' => now(),
                    'fecha_registro' => now(),
                ]
            );
        }

        // Example for a second user in Chia, Cundinamarca
        $usuarioRole = Role::where('rol_descripcion', 'Usuario')->first();
        $chiaMun = Municipio::where('muni_nombre', 'Chía')->first();

        if ($usuarioRole && $chiaMun) {
            User::firstOrCreate(
                ['email' => 'usuario@example.com'],
                [
                    'usua_nombre' => 'Usuario Chia',
                    'password' => Hash::make('password'), // Change 'password' to a secure default
                    'rol_idrol' => $usuarioRole->idrol,
                    'muni_idmuni' => $chiaMun->idmuni,
                    'estado' => 'Activo',
                    'email_verified_at' => now(),
                    'fecha_registro' => now(),
                ]
            );
        }
    }
}
