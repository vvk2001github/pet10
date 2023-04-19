<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ConversationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('conversations')->insert([
            'user_id' => 1,
            'name' => 'Погода',
            'descr' => 'Разговоры о погоде',
        ]);

        DB::table('conversations')->insert([
            'user_id' => 1,
            'name' => 'Флудилка',
            'descr' => 'Разговоры обо всём',
        ]);
    }
}
