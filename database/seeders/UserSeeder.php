<?php

namespace Database\Seeders;

use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
        ]);
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        if(!DB::table('users')->where('email', '===', 'super.admin@example.com')->exists()) {
            DB::table('users')->insert([
                'name' => 'SuperAdmin',
                'email' => 'super.admin@example.com',
                'password' => bcrypt('password'),
                'role_id' => 1,
                'status' => 'active',
            ]);
        }
        UserFactory::new()->count(50)->create();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
