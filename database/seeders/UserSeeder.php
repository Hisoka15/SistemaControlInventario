<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * Sistema de Control de Inventario
     * @author Carlos Briceño (Hisoka15)
     * @license CC BY-NC 4.0 - Uso NO COMERCIAL
     * @version 1.0
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);
        
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        
        // Usar variables de entorno para credenciales (NUNCA hardcodear)
        $adminEmail = env('SEED_ADMIN_EMAIL', 'admin@example.com');
        $adminPassword = env('SEED_ADMIN_PASSWORD', 'ChangeMe123!');
        
        if (!DB::table('users')->where('email', $adminEmail)->exists()) {
            DB::table('users')->insert([
                'name' => 'SuperAdmin',
                'email' => $adminEmail,
                'password' => Hash::make($adminPassword), 
                'role_id' => 1,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
       
        if (app()->environment('local', 'development')) {
            UserFactory::new()->count(50)->create();
        }
        
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
