<?php

namespace Database\Factories;

use App\Models\Adv;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Adv::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->shuffleString('البتثجحخدزسش'),
            'description' => $this->faker->shuffleString('البتثجحخدزسش'),
            'img_resized' => $this->faker->imageUrl(),
            'img_thumb' => $this->faker->imageUrl(),
            'user_id' =>User::inRandomOrder()->first()->id
        ];
    }
}
