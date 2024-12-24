<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'product_code' => 'TKP001',
                'name' => 'Tas Kulit Premium',
                'description' => 'Tas kulit premium dengan desain elegan, cocok untuk berbagai acara.',
                'cost_price' => 80000000,
                'price' => 100000000, // Harga jual utama
                'regular_price' => 100000000,
                'sale_price' => 95000000,
                'stock_quantity' => 10,
                'stock_unit' => 'Piece',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'TRW002',
                'name' => 'Tas Ransel Waterproof',
                'description' => 'Tas ransel dengan material tahan air, ideal untuk aktivitas outdoor.',
                'cost_price' => 30000000,
                'price' => 40000000,
                'regular_price' => 40000000,
                'sale_price' => 35000000,
                'stock_quantity' => 25,
                'stock_unit' => 'Piece',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'TTC003',
                'name' => 'Tas Tote Bag Custom',
                'description' => 'Tote bag custom dengan bahan kanvas berkualitas tinggi.',
                'cost_price' => 20000000,
                'price' => 30000000,
                'regular_price' => 30000000,
                'sale_price' => 25000000,
                'stock_quantity' => 50,
                'stock_unit' => 'Piece',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'TSM004',
                'name' => 'Tas Selempang Multifungsi',
                'description' => 'Tas selempang multifungsi dengan banyak kantong untuk penyimpanan.',
                'cost_price' => 50000000,
                'price' => 60000000,
                'regular_price' => 60000000,
                'sale_price' => 55000000,
                'stock_quantity' => 15,
                'stock_unit' => 'Piece',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'product_code' => 'TTO005',
                'name' => 'Tas Travel Organizer',
                'description' => 'Tas travel organizer untuk menyimpan perlengkapan perjalanan dengan rapi.',
                'cost_price' => 45000000,
                'price' => 55000000,
                'regular_price' => 55000000,
                'sale_price' => 50000000,
                'stock_quantity' => 20,
                'stock_unit' => 'Piece',
                'is_active' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('products')->insert($products);
    }
}
