<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\Talent;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $gallerable = Arr::random([
            Talent::class,
            User::class,
        ]);

        return [
            'uuid' => Str::uuid(),
            'title' => fake()->title(),
            'note' => fake()->paragraph(random_int(5, 10)),
            'gallerable_type' => $gallerable::make()->getMorphClass(),
            'gallerable_id' => $gallerable::factory(),
        ];
    }

    /**
     * Indicate that the post relation.
     *
     * @return static
     */
    public function forPost(Post $post)
    {
        return $this->state([
            'gallerable_id' => $post->id,
            'gallerable_type' => $post->getMorphClass(),
        ]);
    }
}
