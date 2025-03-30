<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $user = User::factory()->create([
            'name' => 'Jean-Marc Strauven',
            'email' => 'jms@grazulex.be',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'remember_token' => Str::random(),
        ]);

    }
}
