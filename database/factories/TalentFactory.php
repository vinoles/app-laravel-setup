<?php

namespace Database\Factories;

use App\Constants\HandPreference;
use App\Models\Talent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Talent>
 */
class TalentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Talent::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'phone' => fake()->phoneNumber(),
            'address' => fake()->streetAddress,
            'city' => fake()->city(),
            'province' => fake()->city(),
            'postal_code' => fake()->postcode,
            'birthdate' => now()->subYears(random_int(11,20)),
            'hand_preference' => HandPreference::random()
        ];
    }
}
