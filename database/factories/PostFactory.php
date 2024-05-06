<?php

namespace Database\Factories;

use App\Models\Talent;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'title' => fake()->paragraph(2),
            'content' => json_encode([
                'image' => 'path',
                'body' => fake()->paragraph(random_int(20, 50)),
                ])
        ];
    }

    /**
     * Indicate that the talent relation.
     *
     * @return static
     */
    public function forTalent(Talent $talent)
    {
        return $this->state([
            'postable_id' => $talent->id,
            'postable_type' => $talent->getMorphClass()
        ]);
    }
}
