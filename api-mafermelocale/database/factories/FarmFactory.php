<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Farm>
 */
class FarmFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(),
            'farm_image' => $this->faker->imageUrl(),
            'short_description' => $this->faker->sentence(),
            'address_id' => $this->faker->numberBetween(1, 100),
            'farm_details_id' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 100),
            'lang_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
