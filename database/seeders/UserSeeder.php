<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'Victor',
            'email' => 'victor@example.com',
            'password' => '$2y$10$2U0u0i0AGxxWR04oR7tyN./36mm1ZjoqskIjWVXWouYSPaye1apfm',
        ]);

        DB::table('users')->insert([
            'name' => 'Nastya',
            'email' => 'nastya@example.com',
            'password' => '$2y$10$2U0u0i0AGxxWR04oR7tyN./36mm1ZjoqskIjWVXWouYSPaye1apfm',
        ]);

        DB::table('users')->insert([
            'name' => 'demo1',
            'email' => 'demo1@example.com',
            'password' => '$2y$10$vxt0QusVoyyqpbaCXNpz2O/DuRbWtYWzxfgF0pIY4/9IV6hcHugii',
        ]);

        DB::table('users')->insert([
            'name' => 'demo9',
            'email' => 'demo9@example.com',
            'password' => '$2y$10$qfy6VbEZbfbbf5hV784lHe/vZPAvT49lsMehr9B6cuRPkNNwf57K6',
        ]);
    }
}
