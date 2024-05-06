<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
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
            'comment' => fake()->paragraph(random_int(20, 50)),
            'post_id' => Post::factory()
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
            'post_id' => $post->id
        ]);
    }
}
