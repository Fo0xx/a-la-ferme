<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_name' => $this->faker->word,
            'price' => $this->faker->randomFloat(2, 0, 100),
            'product_image' => $this->faker->imageUrl(),
            'is_bio' => $this->faker->boolean,
            'is_aop' => $this->faker->boolean,
            'is_aoc' => $this->faker->boolean,
            'is_igp' => $this->faker->boolean,
            'is_stg' => $this->faker->boolean,
            'is_labelrouge' => $this->faker->boolean,
            'category_id' => $this->faker->numberBetween(1, 100),
            'farm_id' => $this->faker->numberBetween(1, 100),
            'currency_id' => $this->faker->numberBetween(1, 100),
            'lang_id' => $this->faker->numberBetween(1, 100),
        ];
    }
}
