<?php

namespace Database\Factories;

use App\Models\Talent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
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
        $postable = Arr::random([
            Talent::class,
            User::class,
        ]);

        return [
            'uuid' => Str::uuid(),
            'title' => fake()->paragraph(2),
            'content' => json_encode([
                'image' => 'path',
                'body' => fake()->paragraph(random_int(20, 50)),
            ]),
            'is_public' => true,
            'postable_id' => $postable::make()->getMorphClass(),
            'postable_type' => $postable::factory(),
        ];
    }

    /**
     * Indicate that the public option
     *
     * @return static
     */
    public function public(Talent $talent)
    {
        return $this->state([
            'is_public' => false,
        ]);
    }

    /**
     * Indicate that the private option
     *
     * @return static
     */
    public function private(Talent $talent)
    {
        return $this->state([
            'is_public' => false,
        ]);
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
            'postable_type' => $talent->getMorphClass(),
        ]);
    }
}
