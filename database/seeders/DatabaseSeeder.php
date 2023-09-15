<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Generate a user with username `admin316` and password `admin`.
         */
        \App\Models\User::factory()->create([
            'username' => 'admin316',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
        ]);

        /**
         * Generate 10 users.
         */
        \App\Models\User::factory(10)->create();

        /**
         * Generate 10 shopping lists.
         */
        // random 10 user
        $users = \App\Models\User::all()->random(10);
        foreach ($users as $user) {
            \App\Models\ShoppingList::factory()->create([
                'user_id' => $user->id,
            ]);
        }
    }
}
