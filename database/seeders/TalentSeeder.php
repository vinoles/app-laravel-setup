<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Talent;
use Illuminate\Database\Seeder;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\ConsoleOutput;

class TalentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $limit = 100;

        $output = new ConsoleOutput();

        $progressBar = new ProgressBar($output, $limit);

        $progressBar->start();

        $talents = Talent::factory()
            ->count($limit )
            ->create();

        $talents->each(function($talent) use($progressBar) {
            $posts = Post::factory()
                ->forTalent($talent)
                ->count(random_int(1,5))
                ->create();

            $posts->each(function($post) {
                Comment::factory()
                    ->count(random_int(1,5))
                    ->forPost($post)
                    ->create();
            });
            $progressBar->advance();
        });

        $progressBar->finish();

        $output->write("\nSave all elements, success", true);
    }
}
