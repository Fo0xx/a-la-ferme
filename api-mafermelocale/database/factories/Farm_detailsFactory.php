<?php

namespace Database\Factories;

use App\Models\Farm_details;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Farm_detailsFactory extends Factory
{

    protected $model = Farm_details::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'about' => $this->faker->sentence(),
            'farm_banner' => $this->faker->imageUrl(),
            'business_mail' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'instagram_id' => $this->faker->sentence(),
            'facebook_id' => $this->faker->sentence(),
            'lang_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
