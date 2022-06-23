<?php

namespace Database\Factories;

use App\Models\Vote;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory

{

    //create a user with a vote relationship
    protected $model = Vote::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'vote' => $this->faker->numberBetween(1, 5),
            'farm_id' => $this->faker->numberBetween(1, 100),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
