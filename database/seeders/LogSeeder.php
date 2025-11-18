<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\logs;
use App\User;
use Carbon\Carbon;

class LogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UserSeeder first.');
            return;
        }

        $actions = [
            'login',
            'logout',
            'view_item',
            'rent_item',
            'return_item',
            'update_profile',
            'change_password',
            'add_item',
            'update_item',
            'delete_item',
            'view_transactions',
            'approve_rental',
            'reject_rental',
            'generate_report',
        ];

        $logsData = [];

        // Create 50 random log entries
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $action = $actions[array_rand($actions)];
            $createdAt = Carbon::now()->subDays(rand(0, 30))->subHours(rand(0, 23))->subMinutes(rand(0, 59));

            // Determine status based on action and user role
            $status = 'success';
            if (in_array($action, ['reject_rental', 'delete_item']) || rand(1, 100) > 95) {
                $status = 'failed';
            }

            // Generate descriptive name based on action
            $name = $this->generateLogName($user, $action);

            $logsData[] = [
                'name' => $name,
                'action' => $action,
                'status' => $status,
                'user_id' => $user->id,
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ];
        }

        // Sort by created_at in descending order
        usort($logsData, function($a, $b) {
            return $b['created_at'] <=> $a['created_at'];
        });

        foreach ($logsData as $log) {
            logs::create($log);
        }

        $this->command->info('Created ' . count($logsData) . ' log entries.');
    }

    /**
     * Generate descriptive log name based on user and action
     */
    private function generateLogName(User $user, string $action): string
    {
        $userName = $user->first_name . ' ' . $user->last_name;

        switch ($action) {
            case 'login':
                return $userName . ' logged into the system';
            case 'logout':
                return $userName . ' logged out of the system';
            case 'view_item':
                return $userName . ' viewed item details';
            case 'rent_item':
                return $userName . ' rented an item';
            case 'return_item':
                return $userName . ' returned a rented item';
            case 'update_profile':
                return $userName . ' updated their profile';
            case 'change_password':
                return $userName . ' changed their password';
            case 'add_item':
                return $userName . ' added a new item to inventory';
            case 'update_item':
                return $userName . ' updated item information';
            case 'delete_item':
                return $userName . ' deleted an item from inventory';
            case 'view_transactions':
                return $userName . ' viewed transaction history';
            case 'approve_rental':
                return $userName . ' approved a rental request';
            case 'reject_rental':
                return $userName . ' rejected a rental request';
            case 'generate_report':
                return $userName . ' generated a system report';
            default:
                return $userName . ' performed ' . $action;
        }
    }
}
