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
        User::query()->where('email', 'test@example.com')->delete();

        User::query()->updateOrCreate(
            ['email' => 'admin@soleils-orient.test'],
            [
                'name' => 'Administration Chatterie',
                'password' => 'admin2000',
                'email_verified_at' => now(),
            ]
        );
    }
}
