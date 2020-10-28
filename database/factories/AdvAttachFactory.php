<?php

namespace Database\Factories;

use App\Models\Adv;
use App\Models\AdvAttach;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvAttachFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = AdvAttach::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'attachment' => $this->faker->firstName(),
            'user_id' =>User::inRandomOrder()->first()->id,
            'adv_id' => Adv::inRandomOrder()->first()->id

        ];
    }
}
