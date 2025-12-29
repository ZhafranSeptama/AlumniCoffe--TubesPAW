<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
    \App\Models\User::create([
    'name' => 'Admin',
    'email' => 'admin@kopi.com',
    'password' => bcrypt('123'),
    'role' => 'admin'
    ]);

    \App\Models\Product::create(['name' => 'Kopi Hitam', 'price' => 10000]);
    \App\Models\Product::create(['name' => 'Latte', 'price' => 15000]);
    }
}
