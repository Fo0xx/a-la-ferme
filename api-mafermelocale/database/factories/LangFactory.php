<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lang>
 */
class LangFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->word(),
            'iso_code' => $this->faker->word(),
            'langage_locale' => $this->faker->word(),
            'date_format_lite' => $this->faker->word(),
            'date_format_full' => $this->faker->word(),
        ];
    }
}
