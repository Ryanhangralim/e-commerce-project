<?php

namespace Database\Seeders;

use App\Models\Conversation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Conversation::create(["chat_id" => 1, "sender" => "customer", "message" => "Good morning"]);
        Conversation::create(["chat_id" => 1, "sender" => "business", "message" => "Good morning too"]);
        Conversation::create(["chat_id" => 1, "sender" => "customer", "message" => "Is this item available?"]);
        Conversation::create(["chat_id" => 1, "sender" => "business", "message" => "Yes it is"]);
    }
}
