<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {

        return [
            'first_name_ar' => $this->faker->shuffleString('البتثجحخدزسش'),
            'last_name_ar' => $this->faker->shuffleString('البتثجحخدزسش'),
            'first_name_en' => $this->faker->firstName,
            'last_name_en' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'emp_id' => $this->faker->unique()->randomNumber(6,true),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ];
    }
}
