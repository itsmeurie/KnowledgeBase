<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


use App\Models\Violator;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'violator_id' => Violator::inRandomOrder()->first()->id,
            'status' => $this->faker->randomElement(['Active', 'Pending', 'Disposed']),
            'citation_number' => $this->faker->regexify('^\d{3}-\d{4}-\d{4}$'),
        ];
    }
}
