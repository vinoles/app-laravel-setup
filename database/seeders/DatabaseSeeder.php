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

        User::factory(10)->create()->each(static function ($user) {
            $user->assignRole(UserRole::random());
        });

        $this->call(UserSeeder::class)
            ->call(TalentSeeder::class);
    }
}
