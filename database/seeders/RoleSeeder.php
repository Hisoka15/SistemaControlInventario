<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('roles')->truncate();
        DB::table('roles')->insert([
            [
                'id' => 1,
                'name' => 'Administrador',
                'description' => 'Acceso total al sistema',
            ],
            [
                'id' => 2,
                'name' => 'Vendedor',
                'description' => 'Acceso al registro de ventas',
            ],
            [
                'id' => 3,
                'name' => 'Consultor',
                'description' => 'Acceso a la consulta de ventas',
            ],
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
