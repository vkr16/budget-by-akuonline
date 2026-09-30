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
        $user = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Fikri Demo',
                'password' => bcrypt('password'),
            ]
        );

        if ($user->pockets()->count() === 0) {
            $kas = $user->pockets()->create([
                'name' => 'Kas & Dompet Tunai',
                'initial_balance' => 500000,
                'current_balance' => 500000,
                'color' => 'zinc',
                'icon' => 'fa-wallet',
                'description' => 'Uang tunai harian di dompet',
            ]);

            $bca = $user->pockets()->create([
                'name' => 'Rekening BCA',
                'initial_balance' => 3500000,
                'current_balance' => 3500000,
                'color' => 'blue',
                'icon' => 'fa-building-columns',
                'description' => 'Rekening operasional dan transfer',
            ]);

            $tabungan = $user->pockets()->create([
                'name' => 'Tabungan & Darurat',
                'initial_balance' => 10000000,
                'current_balance' => 10000000,
                'color' => 'emerald',
                'icon' => 'fa-piggy-bank',
                'description' => 'Dana simpanan tidak boleh disentuh',
            ]);

            $jajan = $user->pockets()->create([
                'name' => 'Jajan & Kopi',
                'initial_balance' => 300000,
                'current_balance' => 300000,
                'color' => 'amber',
                'icon' => 'fa-utensils',
                'description' => 'Budget santai nongkrong dan kuliner',
            ]);

            // Sample transactions
            $user->transactions()->create([
                'pocket_id' => $kas->id,
                'type' => 'out',
                'amount' => 35000,
                'date' => now()->subHours(5),
                'description' => 'Makan siang nasi padang',
            ]);
            $kas->decrement('current_balance', 35000);

            $user->transactions()->create([
                'pocket_id' => $jajan->id,
                'type' => 'out',
                'amount' => 28000,
                'date' => now()->subHours(2),
                'description' => 'Es kopi susu gula aren',
            ]);
            $jajan->decrement('current_balance', 28000);

            $user->transactions()->create([
                'pocket_id' => $bca->id,
                'type' => 'in',
                'amount' => 1500000,
                'date' => now()->subDays(2),
                'description' => 'Honor project website',
            ]);
            $bca->increment('current_balance', 1500000);
        }
    }
}
