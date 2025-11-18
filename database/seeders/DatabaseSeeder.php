<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');

        // Order is important due to foreign key constraints
        $this->call([
            UserSeeder::class,      // Must run first (no dependencies)
            ItemSeeder::class,      // Must run second (no dependencies)
            SerialSeeder::class,    // Depends on items
            TransactionSeeder::class, // Depends on users, items, and serials
            LogSeeder::class,       // Depends on users
        ]);

        $this->command->info('Database seeding completed successfully!');
    }
}
