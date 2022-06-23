<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{

    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'address' => $this->faker->address(),
            'postcode' => $this->faker->postcode(),
            'city' => $this->faker->city(),
            'lon' => $this->faker->longitude(),
            'lat' => $this->faker->latitude(),
            'country_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
