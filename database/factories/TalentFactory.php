<?php

namespace Database\Factories;

use App\Constants\HandPreference;
use App\Models\Talent;
use App\Models\User;
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
            'user_id' => User::factory(),
            'hand_preference' => HandPreference::random()
        ];
    }

    // /**
    //  * Set first_name to talent
    //  *
    //  * @param  string  $firstName
    //  * @return self
    //  */
    // public function withFirstName(string $firstName): self
    // {
    //     return $this->state([
    //         'first_name' => $firstName,
    //     ]);
    // }
}
