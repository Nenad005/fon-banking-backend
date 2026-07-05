<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ActivationCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $user1 = User::create([
            'first_name'   => 'Luka',
            'last_name'    => 'Nenadovic',
            'jmbg'         => '2410001583342',
            'phone_number' => '+381669442557',
            'email'        => 'luka@student.etf.bg.ac.rs',
            'pin_hash'     => null,
            'status'       => 'pending_activation',
        ]);

        ActivationCode::create([
            'user_id'    => $user1->id,
            'code'       => Hash::make('LUKA-2026'),
            'expires_at' => now()->addDays(45),
        ]);

        $user2 = User::create([
            'first_name'   => 'Marko',
            'last_name'    => 'Nenadovic',
            'jmbg'         => '24100053783492',
            'phone_number' => '+381644546204',
            'email'        => 'mn20240174@student.fon.bg.ac.rs',
            'pin_hash'     => null,
            'status'       => 'pending_activation',
        ]);

        ActivationCode::create([
            'user_id'    => $user2->id,
            'code'       => Hash::make('MARKO-2026'),
            'expires_at' => now()->addDays(45),
        ]);

        $this->command->info('Succesfully seeded database');
    }
}
