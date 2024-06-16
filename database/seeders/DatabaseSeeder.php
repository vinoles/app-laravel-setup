<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Constants\UserRole;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(ShieldSeeder::class);

        User::factory(10)->create()->each(function($user){
            $user->assignRole(UserRole::random());
        });

        User::factory()->create([
            'first_name' => 'Admin',
            'last_name' => 'Dogme',
            'email' => 'admin@dogme.com',
            'password' =>  Hash::make('password'),
        ])->assignRole(UserRole::ADMIN);

        $this->call(TalentSeeder::class);
    }
}
