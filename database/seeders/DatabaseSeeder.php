<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Checklist;
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
         * Users
         */
        User::factory()->create([
            'username' => 'skyyinfinity',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin'),
            'last_login_at' => now(),
        ])->each(function ($user) {
            /**
             * Checklists
             */
            Checklist::factory(1)->create(['user_id' => $user->id]);
        });

        User::factory(10)->create()->each(function ($user) {
            /**
             * Checklists
             */
            Checklist::factory(1)->create(['user_id' => $user->id]);
        });

        /**
         * Checklists
         */
    }
}
