<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions_list = [
            ['name' => 'view_dashboard_admin', 'description' => 'Ver dashboard avanzado'],
            ['name' => 'view_users', 'description' => 'Ver listado de usuarios'],
            ['name' => 'show_section_configuration', 'description' => 'Mostrar sección de configuración'],
            ['name' => 'view_permissions', 'description' => 'Ver listado de permisos'],
            ['name' => 'change_role_to_users', 'description' => 'Cambiar rol de usuarios'],
            ['name' => 'change_status_to_users', 'description' => 'Cambiar estado de usuarios'],
            ['name' => 'create_new_user', 'description' => 'Crear nuevo usuario'],
            ['name' => 'view_sales', 'description' => 'Ver ventas'],
            ['name' => 'view_reports', 'description' => 'Ver reportes'],
            ['name' => 'view_products', 'description' => 'Ver productos'],
            ['name' => 'create_new_product', 'description' => 'Registrar nuevo producto'],
            ['name' => 'update_product', 'description' => 'Actualizar producto'],
            ['name' => 'view_backups', 'description' => 'Ver copias de seguridad'],
            ['name' => 'create_backups', 'description' => 'Generar copia de seguridad'],
            ['name' => 'restore_backups', 'description' => 'Restaurar copia de seguridad'],
            ['name' => 'create_new_role', 'description' => 'Crear nuevo rol'],
            ['name' => 'update_role', 'description' => 'Actualizar rol'],
            ['name' => 'delete_product', 'description' => 'Eliminar producto'],
            ['name' => 'view_inventory', 'description' => 'Ver inventarios'],
            ['name' => 'create_new_inventory', 'description' => 'Crear nuevo inventario'],
            ['name' => 'view_purchases', 'description' => 'Ver compras'],
            ['name' => 'register_purchases', 'description' => 'Registro de compras'],
            ['name' => 'store_purchases', 'description' => 'Almacenar compras'],
            ['name' => 'export_data', 'description' => 'Exportar datos'],
            ['name' => 'register_sales', 'description' => 'Registro de ventas'],
            ['name' => 'store_sales', 'description' => 'Almacenar ventas'],
        ];

        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('permissions')->truncate();
        DB::table('permissions')->insert($permissions_list);
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
