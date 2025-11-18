<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\serials;
use App\items;

class SerialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = items::all();

        if ($items->isEmpty()) {
            $this->command->warn('No items found. Please run ItemSeeder first.');
            return;
        }

        $serialsData = [];

        // Create multiple serials for each item (2-5 units per item)
        foreach ($items as $item) {
            $numUnits = rand(2, 5);

            for ($i = 1; $i <= $numUnits; $i++) {
                $serialCode = $item->serial_code . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);

                // Make some serials available and some rented
                $status = ($i <= ceil($numUnits / 2)) ? 'available' : 'rented';

                $serialsData[] = [
                    'serial_code' => $serialCode,
                    'status' => $status,
                    'items_id' => $item->id,
                ];
            }
        }

        foreach ($serialsData as $serial) {
            serials::updateOrCreate(
                [
                    'serial_code' => $serial['serial_code'],
                    'items_id' => $serial['items_id']
                ],
                $serial
            );
        }

        $this->command->info('Created ' . count($serialsData) . ' serial entries for ' . $items->count() . ' items.');
    }
}
