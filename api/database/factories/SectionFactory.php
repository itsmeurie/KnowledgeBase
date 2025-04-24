<?php

namespace Database\Factories;

use App\Models\File;
use App\Models\Office;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Section>
 */
class SectionFactory extends Factory {
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array {
        return [
            "title" => $this->faker->name(),
            "office_id" => Office::inRandomOrder()->first()->id,
            "description" => $this->faker->name(),
            "contents" => $this->faker->text(),
            "slug" => $this->faker->slug(),
        ];
    }
}
