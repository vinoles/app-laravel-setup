<?php

namespace Database\Factories;

use App\Models\Gallery;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Gallery>
 */
class GalleryFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fileName = fake()->uuid().'.png';

        $file = UploadedFile::fake()
            ->create($fileName, 0, 'application/png');

        return [
            'uuid' => Str::uuid(),
            'name' => $fileName,
            'path' => $file->getPathName(),
            'gallery_id' => Gallery::factory(),
        ];
    }

    /**
     * Indicate that the post relation.
     *
     * @return static
     */
    public function forGallery(Gallery $gallery)
    {
        return $this->state([
            'gallery_id' => $gallery->id,
        ]);
    }
}
