<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $posts = Post::factory()
            ->count(100)
            ->create();

        $posts->each(function($post) {
            Comment::factory()
                ->count(random_int(1,5))
                ->forPost($post)
                ->create();
        });
    }
}
