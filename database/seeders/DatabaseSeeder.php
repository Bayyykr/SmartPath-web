<?php

namespace Database\Seeders;

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
        $this->call([
            UserSeeder::class,
            PolsekSeeder::class,
            CategorySeeder::class,
            LocationSeeder::class, // handles location_id mapping in Polseks as well
            LaporanSeeder::class,
            BeritaSeeder::class,
            EmergencyReportSeeder::class,
        ]);
    }
}
