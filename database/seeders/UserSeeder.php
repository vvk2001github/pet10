<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            'email' => 'victor@victor.com',
            'password' => '$2y$10$2U0u0i0AGxxWR04oR7tyN./36mm1ZjoqskIjWVXWouYSPaye1apfm',
        ]);

        DB::table('users')->insert([
            'name' => 'Nastya',
            'email' => 'nastya@victor.com',
            'password' => '$2y$10$2U0u0i0AGxxWR04oR7tyN./36mm1ZjoqskIjWVXWouYSPaye1apfm',
        ]);
    }
}
