<?php

namespace Database\Factories;

use App\Models\Album;
use App\Models\AlbumPhoto;
use Illuminate\Database\Eloquent\Factories\Factory;

class AlbumPhotoFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AlbumPhoto::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'img_resized' => $this->faker->imageUrl(),
            'img_thumb' => $this->faker->imageUrl(),
            'album_id' =>Album::inRandomOrder()->first()->id,

        ];
    }
}
