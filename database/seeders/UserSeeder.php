<?php

namespace Database\Seeders;

use App\Constants\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $password = env('TEST_PASSWORD');

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Dogme',
            'email' => 'admin@app.com',
            'password' => Hash::make($password),
        ])->assignRole(UserRole::ADMIN);

        User::factory()->create([
            'first_name' => 'Dogme',
            'last_name' => 'Test',
            'email' => 'user-test@app.com',
            'password' => Hash::make($password),
        ])->assignRole(UserRole::TALENT);
    }
}
