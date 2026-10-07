<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * El usuario administrador se crea con: php artisan losos:admin
     */
    public function run(): void
    {
        $this->call(CatalogSeeder::class);
    }
}
