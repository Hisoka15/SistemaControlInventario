<?php

namespace Database\Seeders;

use App\Models\Products;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Products::where('status', 1)->get();
        foreach ($products as $product) {
            DB::table('inventories')->insert([
                'code_inventory' => 'INV-' . str_pad($product->id, 6, '0', STR_PAD_LEFT) . '-1',
                'product_id' => $product->id,
                'stock' => 0,
                'total_value' => 0,
                'description' => 'Initial inventory for product ' . $product->name,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
