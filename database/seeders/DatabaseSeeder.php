<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        User::factory()->count(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        //     'password' => bcrypt('password'),
        //     'username' => 'test_user',
        //     'bio' => 'Test user bio',
        //     'phone_number' => '1234567890',
        //     'status' => 'online'
        // ]);
        // Check if user already exists before creating
        if (!User::where('email', 'new@example.com')->exists()) {
            User::create([
                'name' => 'New User',
                'email' => 'new@example.com',
                'password' => bcrypt('password'),
                'username' => $this->generateUniqueUsername('test_user'),
                'bio' => 'Test user bio',
                'phone_number' => '1234567890',
                'status' => 'online'
            ]);
        }

        User::create([
            'name' => 'old User',
            'email' => 'old@example.com',
            'password' => bcrypt('password'),
            'username' => $this->generateUniqueUsername('test_user'),
            'bio' => 'Test user bio',
            'phone_number' => '1234567890',
            'status' => 'online'
        ]);
    }


    // Helper method to generate unique username
    private function generateUniqueUsername($base)
    {
        $username = $base;
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = $base . '_' . $counter;
            $counter++;
        }

        return $username;
    }
}
