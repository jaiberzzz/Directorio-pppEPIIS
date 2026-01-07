<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleAndAdminSeeder::class,
                // UserSeeder::class, // Comentado para no duplicar si ya existen
            SettingSeeder::class,
        ]);
    }
}
