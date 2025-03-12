<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Gender;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Violator>
 */
class ViolatorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName(),
            'middle_name' => $this->faker->lastName(),
            'last_name' => $this->faker->lastName(),
            'gender_id' => Gender::inRandomOrder()->first()->id,

        ];
    }
}
