<?php

namespace Database\Seeders;

use App\Models\Data\ProductsData;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = ProductsData::$products;
        foreach ($products as $product) {
            DB::table('products')->insert([
                'name' => $product['name'],
                'price' => $product['price'],
                'unit_of_measurement' => $product['unit_of_measurement'],
                'type_of_measurement' => $product['type_of_measurement'],
                'description' => 'Descripción del producto: ' . $product['name'],
                'status' => 1,
                'code' => 'C-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
