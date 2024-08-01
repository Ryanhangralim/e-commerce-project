<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'business_id' => 1,
            'name' => 'Uniqlo UT',
            'description' => 'Uniqlo T-Shirt for everyone',
            'brand' => 'Uniqlo',
            'category_id' => 2,
            'price' => 199000
        ]);
    }
}
