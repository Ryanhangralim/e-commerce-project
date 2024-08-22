<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::create([
            'transaction_id' => 1,
            'product_id' => 1,
            'price' => 10000,
            'quantity' => 2,
            'total_price' => 20000
        ]);

        Order::create([
            'transaction_id' => 2,
            'product_id' => 2,
            'price' => 10000,
            'quantity' => 2,
            'total_price' => 20000
        ]);
        Order::factory(50)->create();
    }
}