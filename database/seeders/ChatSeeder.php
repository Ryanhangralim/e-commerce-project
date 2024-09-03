<?php

namespace Database\Seeders;

use App\Models\Chat;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ChatSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        Chat::create([
            "user_id" => 1,
            "business_id" => 1,
        ]);
        Chat::create([
            "user_id" => 1,
            "business_id" => 2,
        ]);
    }
}
