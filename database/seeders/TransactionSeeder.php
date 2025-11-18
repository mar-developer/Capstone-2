<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\transactions;
use App\items;
use App\User;
use App\serials;
use Carbon\Carbon;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('access', 'user')->get();
        $rentedSerials = serials::where('status', 'rented')->with('items')->get();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        if ($rentedSerials->isEmpty()) {
            $this->command->warn('No rented serials found. Please run SerialSeeder first.');
            return;
        }

        $transactionsData = [];
        $transactionCounter = 1;

        foreach ($rentedSerials->take(15) as $serial) {
            $item = items::find($serial->items_id);
            if (!$item) continue;

            $user = $users->random();
            $duration = rand(3, 30); // Random duration between 3 and 30 days
            $rentDate = Carbon::now()->subDays(rand(1, 10));
            $returnDate = $rentDate->copy()->addDays($duration);

            // Some transactions are ongoing, some are completed, some are overdue
            $rand = rand(1, 100);
            if ($rand <= 40) {
                $status = 'ongoing';
            } elseif ($rand <= 70) {
                $status = 'completed';
                $returnDate = $rentDate->copy()->addDays(rand(1, $duration));
            } else {
                $status = 'overdue';
                $returnDate = Carbon::now()->subDays(rand(1, 5));
            }

            $transactionCode = 'TXN-' . Carbon::now()->format('Y') . '-' . str_pad($transactionCounter, 5, '0', STR_PAD_LEFT);

            $transactionsData[] = [
                'transaction_code' => $transactionCode,
                'serial_code' => $serial->serial_code,
                'name' => $item->name,
                'img_path' => $item->img_path,
                'rent_date' => $rentDate->format('Y-m-d'),
                'return_date' => $returnDate->format('Y-m-d'),
                'duration' => $duration,
                'price' => $item->price * $duration,
                'status' => $status,
                'items_id' => $item->id,
                'users_id' => $user->id,
            ];

            $transactionCounter++;
        }

        foreach ($transactionsData as $transaction) {
            transactions::updateOrCreate(
                ['transaction_code' => $transaction['transaction_code']],
                $transaction
            );
        }

        $this->command->info('Created ' . count($transactionsData) . ' transaction entries.');
    }
}
